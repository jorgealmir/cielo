# Integração com a Cielo

Integração com a Cielo-3.0

## Dependencies
* PHP >= 7.2
* developercielo/api-3.0-php

## Features

* [x] Create Payment
    * [x] Credit/Debit Card
    * [x] Wallet (Visa Checkout / Masterpass / Apple Pay / Samsung Pay)
    * [x] Boleto
    * [x] Eletronic Transfer
    * [x] Recurrent
* [x] Update Payment
    * [x] Capture
    * [x] Void
    * [ ] Recurrent Payment
* [x] Query Payment
    * [x] By Payment ID
    * [ ] By Order ID
* [x] Query Card Bin
* [ ] Tokenize Card
* [ ] Fraud Analysis
* [ ] Velocity
* [ ] Zero Auth
* [ ] Silent Order Post

## Para instalar a bíblioteca, execute o seguinte comando:

```json
"require": {
    "ja-martins/cielo": "^2.0"
}
```

## Para usar a biblioteca:
```php
<? php

require __DIR__ . '/vendor/autoload.php';

use Src\Payments;

$cielo = new Payments(
    "merchantId", 
    "merchantKey", 
    true // = sandbox e false = production
);
```


## Cartão de Crédito:
```php
$cielo->creditCard(
    "123", // Número do pedido
    15700, // Valor do pedido
    321, // Código de segurança
    "Visa", Bandeira 
    "10/2023", // Data de expiração
    "0000000000000001", // Número do cartão
    "Fulano de Tal" // Nome no cartão
);
```

### Developer
* [Jorge Almir Martins] - Desenvolvedor da bíblioteca

License
----

MIT
