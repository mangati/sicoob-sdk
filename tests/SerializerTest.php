<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Tests;

use DateTimeImmutable;
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletosResponse;
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletosResultado;
use Mangati\Sicoob\Dto\CobrancaBancaria\SegundaViaBoletoRequest;
use Mangati\Sicoob\Dto\Pix\ConsultaPixRequest;
use Mangati\Sicoob\Dto\Pix\NovaCobrancaVencimentoRequest;
use Mangati\Sicoob\Model\Pix\CalendarioVencimento;
use Mangati\Sicoob\Model\Pix\InfoAdicional;
use Mangati\Sicoob\Model\Pix\JurosMulta;
use Mangati\Sicoob\Model\Pix\Pessoa;
use Mangati\Sicoob\Model\Pix\ValorCobranca;
use Mangati\Sicoob\SerializerFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class SerializerTest extends TestCase
{
    public function testIncluirBoletoResponse(): void
    {
        $json = TestUtils::readResource('incluir-boletos-response.json');

        $serializer = SerializerFactory::createSerializer();
        $response = $serializer->deserialize($json, IncluirBoletosResponse::class, 'json');

        $this->assertInstanceOf(IncluirBoletosResponse::class, $response);
        $this->assertCount(1, $response->resultado);
        $this->assertInstanceOf(IncluirBoletosResultado::class, $response->resultado[0]);
    }

    public function testNovaCobrancaVencimentoRequest(): void
    {
        $dt = DateTimeImmutable::createFromFormat('Y-m-d', '2023-01-03');
        $request = new NovaCobrancaVencimentoRequest(
            calendario: new CalendarioVencimento(
                dataDeVencimento: $dt,
                validadeAposVencimento: 7,
            ),
            devedor: new Pessoa(
                nome: 'Nome Devedor',
                cpf: '12345678900',
            ),
            valor: new ValorCobranca(
                original: '23.44',
                multa: new JurosMulta(1, '5.00'),
                juros: new JurosMulta(2, '15.00'),
            ),
            chave: 'chave',
            solicitacaoPagador: 'solicitacao',
            infoAdicionais: [
                new InfoAdicional('nome', '10.23'),
            ],
        );

        $serializer = SerializerFactory::createSerializer();
        $json = $serializer->serialize($request, 'json');

        $expectedJson = TestUtils::readResource('nova-cobranca-vencimento-request.json');
        $this->assertJsonStringEqualsJsonString($expectedJson, $json);
    }

    public function testNormalizer(): void
    {
        $data = new SegundaViaBoletoRequest(
            numeroContrato: '123',
            modalidade: 1,
            nossoNumero: '333',
            gerarPdf: true,
        );

        $normalizer = SerializerFactory::createNormalizer();
        $actualData = $normalizer->normalize($data, 'array');

        $expectedData = [
            'numeroContrato' => '123',
            'modalidade' => 1,
            'nossoNumero' => '333',
            'gerarPdf' => true,
        ];
        $this->assertSame($expectedData, $actualData);
    }

    public function testNormalizerIgnoringNull(): void
    {
        $dt = DateTimeImmutable::createFromFormat('!Y-m-d', '2023-11-21');
        $data = new ConsultaPixRequest(
            inicio: $dt,
            fim: $dt,
            txid: null,
            cpf: null,
            cnpj: null,
        );

        $normalizer = SerializerFactory::createNormalizer();
        $actualData = $normalizer->normalize($data, 'array', [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]);

        $expectedData = [
            'inicio' => '2023-11-21T00:00:00+00:00',
            'fim' => '2023-11-21T00:00:00+00:00',
        ];
        $this->assertEquals($expectedData, $actualData);
    }
}
