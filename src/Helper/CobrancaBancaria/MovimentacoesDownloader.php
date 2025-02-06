<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Helper\CobrancaBancaria;

use DateTimeInterface;
use Generator;
use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\CobrancaBancaria\ConsultarMovimentacoesRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\DownloadMovimentacoesRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\SolicitarMovimentacoesRequest;
use Mangati\Sicoob\Exception\SicoobException;
use Mangati\Sicoob\Model\CobrancaBancaria\Movimentacao;
use Mangati\Sicoob\Model\CobrancaBancaria\MovimentacaoDownload;
use Mangati\Sicoob\SerializerFactory;
use Mangati\Sicoob\SicoobCobrancaBancariaClient;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;
use ZipArchive;

/**
 * Helper class to automatically download and extract movimentacao files
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class MovimentacoesDownloader
{
    private readonly SerializerInterface $serializer;

    public function __construct(
        private readonly SicoobCobrancaBancariaClient $client,
    ) {
        $this->serializer = SerializerFactory::createSerializer();
    }

    /**
     * This method makes a request for Movimentacoes, wait for a valid response, then download
     * and extract the files mapping each record to Movimentacao::class
     *
     * @param int $maxAttempts The number of attempts to get the requested Movimentacoes
     * @param int $usleepTime The microseconds to wait between each attempt
     * @return Generator<Movimentacao>
     */
    public function download(
        AuthenticationToken $token,
        int $numeroCliente,
        int $tipoMovimento,
        DateTimeInterface $dataInicial,
        DateTimeInterface $dataFinal,
        int $maxAttempts = 10,
        int $usleepTime = 1000,
    ): Generator {
        if (!class_exists(ZipArchive::class)) {
            throw new RuntimeException(
                'A extensão zip é necessária para poder extrair o conteúdo das movimentações'
            );
        }

        $solicitacaoResponse = $this->client->solicitarMovimentacoes($token, new SolicitarMovimentacoesRequest(
            numeroCliente: $numeroCliente,
            tipoMovimento: $tipoMovimento,
            dataInicial: $dataInicial,
            dataFinal: $dataFinal,
        ));

        $consultaResponse = null;
        while ($maxAttempts > 0) {
            try {
                $consultaResponse = $this->client->consultarMovimentacoes($token, new ConsultarMovimentacoesRequest(
                    numeroCliente: $numeroCliente,
                    codigoSolicitacao: $solicitacaoResponse->resultado->codigoSolicitacao,
                ));
                break;
            } catch (SicoobException $ex) {
                usleep($usleepTime);
            }
            $maxAttempts--;
        }

        if (!$consultaResponse) {
            throw new RuntimeException(
                sprintf('Unable to get Movimentacoes after %s attempts', $maxAttempts),
            );
        }

        foreach ($consultaResponse->resultado->idArquivos as $idArquivo) {
            $downloadResponse = $this->client->downloadMovimentacoes($token, new DownloadMovimentacoesRequest(
                numeroCliente: $numeroCliente,
                codigoSolicitacao: $solicitacaoResponse->resultado->codigoSolicitacao,
                idArquivo: $idArquivo,
            ));

            yield from $this->extractFiles($downloadResponse->resultado);
        }
    }

    /** @return Generator<Movimentacao> */
    private function extractFiles(MovimentacaoDownload $download): Generator
    {
        $dir = $this->createTempdir();
        $filename = sprintf('%s/%s', $dir, $download->nomeArquivo);
        file_put_contents($filename, base64_decode($download->arquivo));

        $zip = new ZipArchive();
        $zip->open($filename);
        $zip->extractTo($dir);
        $zip->close();

        // unlink($filename);

        yield from $this->mapFiles($dir);
    }

    /** @return Generator<Movimentacao> */
    private function mapFiles(string $dir): Generator
    {
        foreach (glob(sprintf('%s/*.json', $dir)) as $filename) {
            $json = file_get_contents($filename);
            $movimentacoes = $this->serializer->deserialize($json, Movimentacao::class . '[]', 'json');
            yield from $movimentacoes;
            // unlink($filename);
        }
    }

    /** Uses the tempnam function to generate a unique path */
    private function createTempdir(): string
    {
        $dir = sys_get_temp_dir();
        $path = tempnam($dir, 'sicoob-movimentacao-download');
        unlink($path);
        mkdir($path);

        return $path;
    }
}
