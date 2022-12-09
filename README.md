# Sicoob SDK (WIP)

## Configuração

```php
use Mangati\Sicoob\SicoobClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;


$localCert = "path/to/cert.pem";
$localPk = "path/to/cert.key";

$options = new HttpOptions();
$options
    ->setLocalCert($localCert)
    ->setLocalPk($localPk);

$client = HttpClient::create(
    defaultOptions: $options->toArray(),
);

$sicoob = new SicoobClient($client);

```

## Autenticação


```php
use Mangati\Sicoob\Dto\TokenRequest;
use Mangati\Sicoob\Types\TokenScope;

$token = $sicoob->token(new TokenRequest(
    clientId: $clientId,
    scope: TokenScope::COBRANCA_BOLETOS_INCLUIR,
));

print_r($token);

// output:
//
// Mangati\Sicoob\Dto\TokenResponse Object
// (
//     [tokenType] => Bearer
//     [accessToken] => <generated_token>
//     [expiresIn] => 300
//     [refreshExpiresIn] => 0
//     [scope] => cobranca_boletos_incluir
// )

```


## Boleto

> TODO

```php
use Mangati\Sicoob\Dto\IncluirBoletosRequest;
use Mangati\Sicoob\Model\Boleto\Boleto;


$boleto = new Boleto();

$response = $sicoob->incluirBoletos($authToken, new IncluirBoletosRequest(
    boletos: [ $boleto ],
));

print_r($response);
```
