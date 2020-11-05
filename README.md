# Integração com a Cielo

Integration with Cielo-3.0 API

### Dependencies
* PHP >= 7.2
* developercielo/api-3.0-php

### Features

* [x] Create Payment
    * [x] Credit Card
    * [x] Query Credit Card
    * [x] Query Credit Card Details
    * [ ] Debit Card
    * [ ] Wallet (Visa Checkout / Masterpass / Apple Pay / Samsung Pay)
    * [ ] Boleto
    * [ ] Eletronic Transfer
    * [x] Recurrent
* [ ] Update Payment
    * [ ] Capture
    * [ ] Void
    * [ ] Recurrent Payment
* [x] Query Payment
    * [x] By Payment ID
    * [ ] By Order ID
* [ ] Query Card Bin
* [x] Tokenize Card
* [ ] Fraud Analysis
* [ ] Velocity
* [ ] Zero Auth
* [ ] Silent Order Post

### Installation:

If you already have a composer.json file, just add the following dependency to your project:

```json
"require": {
    "ja-martins/cielo": "^2.0"
}
```

With the dependency added to composer.json, just run:

```
composer install
```

Alternatively, you can run directly on your terminal:

```
composer require "ja-martins/cielo"
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

### Consulting a credit card

```php
$card = $cielo->getCreditCard($cardToken);
```

### Checking credit card details

```php
$card = $cielo->getCreditCardData($cardNumber);
```

### Query by PaymentId

```php
$pay = $cielo->queryByPaymentId("$paymentId");
```

### Creating tokenizing a card

```php
/**
 * Tokenizing a card
 */
$cielo->tokenizingCard([
    "customerName" => "Comprador Teste Cielo",
    "cardNumber" => "4532378093777141",
    "holder" => "Comprador T Cielo",
    "expirationDate" => "08/2022",
    "securityCode" => "241",
    "brand" => "Visa"
]);
```

### Creating a tokenized credit card payment

```php
$cielo->payCreditCardTokenized([
    "order" => "321321321321",
    "customerName" => "Teste Customer",
    "amount" => 15700,
    "securityCode" => "321",
    "brand" => "Visa",
    "cardToken" => "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
]);
```


### Creating a credit card payment:

To create a simple credit card payment with the SDK, simply do:

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

### Creating a recurring payment
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
            "CardNumber" => "4532378093777141",
            "Holder" => "Holder",
            "ExpirationDate" => "07/2021",
            "SecurityCode" => "241",
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
