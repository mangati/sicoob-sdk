# Sicoob SDK

## Configuração

```php
use Mangati\Sicoob\SicoobClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;;


$localCert = "path/to/cert.pem";
$localPk = "path/to/cert.key";

$options = new HttpOptions();
$options
    ->setLocalCert($localCert)
    ->setLocalPk($localPk);

$client = HttpClient::create(
    defaultOptions: $options->toArray(),
);

// pix
$sicoob = new SicoobPixClient($client);
// boleto
$sicoob = new SicoobCobrancaBancariaClient($client);
// conta corrente
$sicoob = new SicoobContaCorrenteClient($client);
```

## Autenticação

Production:

```php
use Mangati\Sicoob\Dto\TokenRequest;
use Mangati\Sicoob\Types\TokenScope;

$response = $sicoob->token(new TokenRequest(
    clientId: $clientId,
    scopes: [ TokenScope::COBRANCA_BOLETOS_INCLUIR ],
));

print_r($response);
// output:
//
// Mangati\Sicoob\Dto\TokenResponse Object
// (
//   [token] => Mangati\Sicoob\Dto\AuthenticationToken Object
//     (
//       [clientId] => <client_id>
//       [tokenType] => Bearer
//       [accessToken] => <generated_token>
//       [expiresIn] => 300
//       [refreshExpiresIn] => 0
//       [scopes] => Array
//          (
//            [0] => Mangati\Sicoob\Types\TokenScope Enum:string
//              (
//                [name] => COBRANCA_BOLETOS_INCLUIR
//                [value] => cobranca_boletos_incluir
//              )
//          )
//     )
// )
```

Sandbox:

```php
use Mangati\Sicoob\SicoobCobrancaBancariaClient;
use Mangati\Sicoob\Dto\AuthenticationToken;

/** @var AuthenticationToken */
$token = SicoobCobrancaBancariaClient::sandboxToken();

// then
$sicoob = new SicoobCobrancaBancariaClient($client, isSandbox: true);
```


## Cobrança Bancária - Boleto

```php
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletosRequest;
use Mangati\Sicoob\Model\CobrancaBancaria\Boleto;

$boleto = new Boleto();

$response = $sicoob->incluirBoletos($authToken, new IncluirBoletosRequest(
    boletos: [ $boleto ],
));

$resultado = $response->resultado[0];

if ($resultado->status->codigo !== 200) {
    throw new \Exception($resultado->status->mensagem);
}

$base64Data = $resultado->boleto->pdfBoleto;
$nossoNumero = $resultado->boleto->nossoNumero;
```
