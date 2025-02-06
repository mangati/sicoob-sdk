<?php

namespace Mangati\Sicoob\Tests\Helper\CobrancaBancaria;

use DateTimeImmutable;
use Mangati\Sicoob\Dto\CobrancaBancaria\ConsultarMovimentacoesResponse;
use Mangati\Sicoob\Dto\CobrancaBancaria\DownloadMovimentacoesResponse;
use Mangati\Sicoob\Dto\CobrancaBancaria\SolicitarMovimentacoesResponse;
use Mangati\Sicoob\Helper\CobrancaBancaria\MovimentacoesDownloader;
use Mangati\Sicoob\Model\CobrancaBancaria\Movimentacao;
use Mangati\Sicoob\Model\CobrancaBancaria\MovimentacaoDownload;
use Mangati\Sicoob\Model\CobrancaBancaria\SolicitacaoMovimentacao;
use Mangati\Sicoob\Model\CobrancaBancaria\ResumoMovimentacoes;
use Mangati\Sicoob\SicoobClientBase;
use Mangati\Sicoob\SicoobCobrancaBancariaClient;
use Mangati\Sicoob\Tests\TestUtils;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpClient\Response\MockResponse;

class MovimentacoesDownloaderTest extends TestCase
{
    public function testDownload(): void
    {
        $token = SicoobClientBase::sandboxToken('clientId', 'accessToken');
        $numeroCliente = 111;
        $tipoMovimento = 1;
        $codigoSolicitacao = 222;
        $idArquivo = 333;
        $dataInicial = new DateTimeImmutable('2025-01-05T10:32:40Z');
        $dataFinal = new DateTimeImmutable('2025-01-07T12:23:52Z');

        $client = new MockHttpClient([
            function ($method, $url, $options) use ($codigoSolicitacao): MockResponse {
                $this->assertSame('POST', $method);
                $this->assertSame(
                    '{"numeroCliente":111,"tipoMovimento":1,"dataInicial":"2025-01-05","dataFinal":"2025-01-07"}',
                    $options['body'],
                );

                return new JsonMockResponse(new SolicitarMovimentacoesResponse(
                    resultado: new SolicitacaoMovimentacao('ok', $codigoSolicitacao),
                ));
            },
            function ($method, $url, $options) use ($codigoSolicitacao, $idArquivo): MockResponse {
                $this->assertSame('GET', $method);
                $this->assertSame(111, $options['query']['numeroCliente']);
                $this->assertSame($codigoSolicitacao, $options['query']['codigoSolicitacao']);

                return new JsonMockResponse(new ConsultarMovimentacoesResponse(
                    resultado: new ResumoMovimentacoes(
                        quantidadeTotalRegistros: 1,
                        quantidadeArquivo: 1,
                        idArquivos: [$idArquivo],
                    ),
                ));
            },
            function ($method, $url, $options) use ($codigoSolicitacao, $idArquivo): MockResponse {
                $this->assertSame('GET', $method);
                $this->assertSame(111, $options['query']['numeroCliente']);
                $this->assertSame($codigoSolicitacao, $options['query']['codigoSolicitacao']);
                $this->assertSame($idArquivo, $options['query']['idArquivo']);

                return new JsonMockResponse(new DownloadMovimentacoesResponse(
                    resultado: new MovimentacaoDownload(
                        arquivo: TestUtils::readResourceAsBase64('download-movimentacoes.zip'),
                        nomeArquivo: 'test.zip',
                    ),
                ));
            },
        ]);

        $downloader = new MovimentacoesDownloader(new SicoobCobrancaBancariaClient($client));

        $movimentacoes = $downloader->download(
            $token,
            $numeroCliente,
            $tipoMovimento,
            $dataInicial,
            $dataFinal
        );

        $count = 0;
        /** @var Movimentacao $movimentacao */
        foreach ($movimentacoes as $movimentacao) {
            $this->assertInstanceOf(Movimentacao::class, $movimentacao);
            $this->assertSame('ENTR', $movimentacao->siglaMovimento);
            $this->assertSame('2025-01-05', $movimentacao->dataInicioMovimento->format('Y-m-d'));
            $this->assertSame('2025-01-07', $movimentacao->dataFimMovimento->format('Y-m-d'));
            $this->assertSame(150.0, $movimentacao->valorTitulo);
            $this->assertSame(123456, $movimentacao->numeroCliente);
            $this->assertSame(987654, $movimentacao->numeroContrato);
            $this->assertSame(102938, $movimentacao->numeroContaCorrente);
            $this->assertSame(1234, $movimentacao->numeroContratoCobranca);
            $count++;
        }

        $this->assertSame(4, $count);
    }
}
