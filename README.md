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

Produção:

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
//                [value] => boletos_inclusao
//              )
//          )
//       [isSandbox] => false
//     )
// )
```

Sandbox:

```php
use Mangati\Sicoob\SicoobCobrancaBancariaClient;
use Mangati\Sicoob\Dto\AuthenticationToken;

// Acesse https://developers.sicoob.com.br/portal/sandbox 
// para pegar o "Client ID" e o "Access Token (Bearer)"

/** @var AuthenticationToken */
$token = SicoobCobrancaBancariaClient::sandboxToken(
    clientId: '<sandbox-client-id>',
    accessToken: '<sandbox-access-token>',
);
```


## Cobrança Bancária - Boleto

```php
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletoRequest;
use Mangati\Sicoob\Model\CobrancaBancaria\Boleto;

$auth = $sicoob->token(new TokenRequest(
    clientId: $clientId,
    scopes: [ TokenScope::COBRANCA_BOLETOS_INCLUIR ],
));

$response = $sicoob->incluirBoleto($auth->token, new IncluirBoletoRequest(
    boleto: new Boleto(),
));

/** @var Boleto */
$boleto = $response->resultado;

$base64Data = $boleto->pdfBoleto;
$nossoNumero = $boleto->nossoNumero;
```
