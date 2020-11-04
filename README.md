# Integração com a Cielo

Integration with Cielo-3.0 API

### Dependencies
* PHP >= 7.2
* developercielo/api-3.0-php

### Features

* [x] Create Payment
    * [x] Credit Card
    * [ ] Debit Card
    * [ ] Wallet (Visa Checkout / Masterpass / Apple Pay / Samsung Pay)
    * [ ] Boleto
    * [ ] Eletronic Transfer
    * [x] Recurrent
* [ ] Update Payment
    * [ ] Capture
    * [ ] Void
    * [ ] Recurrent Payment
* [ ] Query Payment
    * [ ] By Payment ID
    * [ ] By Order ID
* [ ] Query Card Bin
* [ ] Tokenize Card
* [ ] Fraud Analysis
* [ ] Velocity
* [ ] Zero Auth
* [ ] Silent Order Post

### Para instalar a bíblioteca, execute o seguinte comando:

```json
"require": {
    "ja-martins/cielo": "^2.0"
}
```

### To use the library:
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


### Credit Card:
```php
/**
 * Payment by credit card
 */
$cielo->payCreditCard([
    "order" => "321321321321",
    "amount" => 15700,
    "securityCode" => "321",
    "brand" => "Visa",
    "expirationDate" => "10/2023",
    "cardNumber" => "0000000000000001",
    "holder" => "Fulano de Tall",
    "customerName" => "Fulano de Tal"
]);
```

### Credit Card Recurrent
```php
/**
 * Recurring payment
 */
$cielo->payRecurrent([
    "MerchantOrderId" => "2014113245231706",
    "Customer" => [
        "Name" => "Comprador rec programada"
    ],
    "Payment" => [
        "Type" => 'CreditCard',
        "Amount" => 15700, // 157,00
        "Installments" => 1,
        "SoftDescriptor" => "Your Company",
        "RecurrentPayment" => [
            "AuthorizeNow" => true,
            "EndDate" => "2019-12-01",
            "Interval" => "SemiAnnual"
        ],
        "CreditCard" => [
            "CardNumber" => "4532378093777141", //"4485070956267065",
            "Holder" => "Holder",
            "ExpirationDate" => "07/2021", //"08/2022",
            "SecurityCode" => "241", //"842",
            "SaveCard" => false,
            "Brand" => "Visa"
        ]
    ]
]);
```

### Developer
* [Jorge Almir Martins] - Desenvolvedor da bíblioteca

License
----

MIT
