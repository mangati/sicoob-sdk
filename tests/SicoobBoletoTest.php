<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Tests;

use DateTimeImmutable;
use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\CobrancaBancaria\BaixarBoletoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\ConsultaBoletoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\ConsultarMovimentacoesRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\DownloadMovimentacoesRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\SolicitarMovimentacoesRequest;
use Mangati\Sicoob\Exception\SicoobException;
use Mangati\Sicoob\Model\CobrancaBancaria\Boleto;
use Mangati\Sicoob\Model\CobrancaBancaria\Pagador;
use Mangati\Sicoob\Model\CobrancaBancaria\SituacaoBoleto;
use Mangati\Sicoob\SicoobCobrancaBancariaClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class SicoobBoletoTest extends TestCase
{
    private const CLIENT_ID = 'testClientId';
    private const ACCESS_TOKEN = 'testAccessToken';

    public function testIncluirBoleto(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/cobranca-bancaria/v3/boletos';
                $expectedBody = TestUtils::readResource('incluir-boleto-request.json');

                $this->assertSame('POST', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);
                $this->assertJsonStringEqualsJsonString($expectedBody, $options['body']);

                return new MockResponse(
                    TestUtils::readResource('incluir-boleto-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = $this->buildToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $response = $sicoob->incluirBoleto($token, new IncluirBoletoRequest(
            boleto: $this->buildBoleto(),
        ));

        $this->assertInstanceOf(Boleto::class, $response->resultado);
        $this->assertSame(999999, $response->resultado->numeroCliente);
    }

    public function testIncluirBoletoSandboxUrl(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://sandbox.sicoob.com.br/sicoob/sandbox/cobranca-bancaria/v3/boletos';

                $this->assertSame('POST', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('incluir-boleto-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = SicoobCobrancaBancariaClient::sandboxToken(self::CLIENT_ID, self::ACCESS_TOKEN);
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $sicoob->incluirBoleto($token, new IncluirBoletoRequest(
            boleto: $this->buildBoleto(),
        ));
    }

    public function testConsultaBoleto(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/cobranca-bancaria/v3/boletos?';

                $this->assertSame('GET', $method);
                $this->assertStringStartsWith($expectedUrl, $url);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);
                $this->assertSame(222, $options['query']['numeroCliente']);
                $this->assertSame(1, $options['query']['codigoModalidade']);
                $this->assertSame(123, $options['query']['nossoNumero']);
                $this->assertSame('testLinhaDigitavel', $options['query']['linhaDigitavel']);
                $this->assertSame('testCodigoBarras', $options['query']['codigoBarras']);
                $this->assertSame('testNumeroContratoCobranca', $options['query']['numeroContratoCobranca']);

                return new MockResponse(
                    TestUtils::readResource('consulta-boleto-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = $this->buildToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $response = $sicoob->consultarBoleto($token, new ConsultaBoletoRequest(
            numeroCliente: 222,
            codigoModalidade: 1,
            nossoNumero: 123,
            linhaDigitavel: 'testLinhaDigitavel',
            codigoBarras: 'testCodigoBarras',
            numeroContratoCobranca: 'testNumeroContratoCobranca',
        ));

        $this->assertInstanceOf(Boleto::class, $response->resultado);
        $this->assertSame(999999, $response->resultado->numeroCliente);
        $this->assertCount(1, $response->resultado->listaHistorico);
        $this->assertSame(SituacaoBoleto::EM_ABERTO, $response->resultado->situacaoBoleto);
        $this->assertSame(1, $response->resultado->listaHistorico[0]->tipoHistorico);
        $this->assertSame(
            'TARIFA - TAR. MANUTENÇÃO DE TÍTULO VENCIDO - R$ 0,75',
            $response->resultado->listaHistorico[0]->descricaoHistorico,
        );
    }

    public function testBaixarBoleto(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/cobranca-bancaria/v3/boletos/123/baixar';
                $expectedBody = '{"numeroCliente":333,"codigoModalidade":1}';

                $this->assertSame('POST', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertSame($expectedBody, $options['body']);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('baixar-boleto-response.json'),
                    [ 'http_code' => 204 ]
                );
            },
        ]);

        $token = $this->buildToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $sicoob->baixarBoleto($token, new BaixarBoletoRequest(
            nossoNumero: 123,
            numeroCliente: 333,
            codigoModalidade: 1,
        ));
    }

    public function testSolicitarMovimentacoes(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/cobranca-bancaria/v3/boletos/movimentacoes';
                $expectedBody = '{"numeroCliente":123,"tipoMovimento":1,' .
                    '"dataInicial":"2025-01-03","dataFinal":"2025-01-05"}';

                $this->assertSame('POST', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertSame($expectedBody, $options['body']);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('solicitar-movimentacoes-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = $this->buildToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $response = $sicoob->solicitarMovimentacoes($token, new SolicitarMovimentacoesRequest(
            numeroCliente: 123,
            tipoMovimento: 1,
            dataInicial: new DateTimeImmutable('2025-01-03T10:34:00Z'),
            dataFinal: new DateTimeImmutable('2025-01-05T10:34:02Z'),
        ));

        $this->assertSame(12345678, $response->resultado->codigoSolicitacao);
    }

    public function testConsultarMovimentacoes(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/cobranca-bancaria/v3/boletos/movimentacoes?';

                $this->assertSame('GET', $method);
                $this->assertStringStartsWith($expectedUrl, $url);
                $this->assertSame(123, $options['query']['numeroCliente']);
                $this->assertSame(98760, $options['query']['codigoSolicitacao']);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('consultar-movimentacoes-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = $this->buildToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $response = $sicoob->consultarMovimentacoes($token, new ConsultarMovimentacoesRequest(
            numeroCliente: 123,
            codigoSolicitacao: 98760,
        ));

        $this->assertSame(2, $response->resultado->quantidadeTotalRegistros);
        $this->assertSame(1, $response->resultado->quantidadeArquivo);
        $this->assertContains(12345678, $response->resultado->idArquivos);
    }

    public function testConsultarMovimentacoesWhenItIsNotReadyYet(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                return new MockResponse(
                    '',
                    [ 'http_code' => 204 ]
                );
            },
        ]);

        $token = $this->buildToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $this->expectException(SicoobException::class);
        $this->expectExceptionMessage(
            'SicoobException: body=, statusCode=204,' .
            ' url=https://api.sicoob.com.br/cobranca-bancaria/v3/boletos/movimentacoes'
        );

        $sicoob->consultarMovimentacoes($token, new ConsultarMovimentacoesRequest(
            numeroCliente: 123,
            codigoSolicitacao: 98760,
        ));
    }

    public function testDownloadMovimentacoes(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/cobranca-bancaria/v3/boletos/movimentacoes/download?';

                $this->assertSame('GET', $method);
                $this->assertStringStartsWith($expectedUrl, $url);
                $this->assertSame(123, $options['query']['numeroCliente']);
                $this->assertSame(98760, $options['query']['codigoSolicitacao']);
                $this->assertSame(123456, $options['query']['idArquivo']);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('download-movimentacoes-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = $this->buildToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $response = $sicoob->downloadMovimentacoes($token, new DownloadMovimentacoesRequest(
            numeroCliente: 123,
            codigoSolicitacao: 98760,
            idArquivo: 123456,
        ));

        $this->assertSame('ENTR_3066_189189_201904260922011189887_47_0.zip', $response->resultado->nomeArquivo);
    }

    private function buildToken(): AuthenticationToken
    {
        return new AuthenticationToken(
            clientId: self::CLIENT_ID,
            accessToken: self::ACCESS_TOKEN,
            tokenType: 'Bearer',
            expiresIn: 1,
            refreshExpiresIn: 1,
            scopes: [],
        );
    }

    private function buildBoleto(): Boleto
    {
        return new Boleto(
            numeroCliente: 999999,
            codigoModalidade: 1,
            numeroContaCorrente: 123456,
            codigoEspecieDocumento: "FAT",
            dataEmissao: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-15'),
            seuNumero: "158",
            identificacaoEmissaoBoleto: 2,
            identificacaoDistribuicaoBoleto: 2,
            valor: 150.00,
            dataVencimento: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-22'),
            dataMulta: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-23'),
            dataJurosMora: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-23'),
            tipoDesconto: 0,
            tipoMulta: 2,
            valorMulta: 5.00,
            tipoJurosMora: 2,
            valorJurosMora: 2.00,
            numeroParcela: 1,
            pagador: new Pagador(
                numeroCpfCnpj: "12345678901234",
                nome: "Nome do Pagador",
                endereco: "Av. Teste, 1000",
                bairro: "Bairro Teste",
                cidade: "Cidade Teste",
                cep: "12345678",
                uf: "TT",
                email: "email@test.com"
            ),
            gerarPdf: true,
        );
    }
}
