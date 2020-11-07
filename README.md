# Integração com a Cielo

Integration with Cielo-3.0 API

### Dependencies
* PHP >= 7.2
* developercielo/api-3.0-php

### Features

* [x] Credit Card
    * [x] Query Credit Card
    * [x] Query Credit Card Details
    * [x] Query Credit Card Recurrent
* [x] Create Payment
    * [x] Credit Card
    * [ ] Debit Card
    * [ ] Wallet (Visa Checkout / Masterpass / Apple Pay / Samsung Pay)
    * [ ] Boleto
    * [ ] Eletronic Transfer
    * [x] Recurrent
* [ ] Update Payment
    * [ ] Buyer Data Recurrent
    * [ ] Capture
    * [ ] Void
    * [ ] Recurrent Payment
* [x] Query Payment
    * [x] By Payment ID
    * [x] By Order ID
* [ ] Query Card Bin
* [x] Credit Card Tokenizations
    * [x] creating a tokenized card
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

if (!empty($card)) {
    var_dump($card);
}
```

### Checking credit card details

```php
$card = $cielo->getCreditCardData($cardNumber);

if (!empty($card)) {
    var_dump($card);
}
```

### Query by PaymentId

```php
$pay = $cielo->queryByPaymentId("$paymentId");

var_dump($cielo->getMessage());

var_dump($pay);
```

### Query by merchant order ID

```php
$order = $cielo->queryByOrderId($merchantOrderId);

var_dump($cielo->getMessage());

if ($cielo->getStatus() == 0) {
    var_dump($order);
}
```

### Query Recurrent Payment ID

```php
$recurrent = $cielo->queryRecurrent($recurrentPaymentId);

var_dump($cielo->getMessage());

if ($cielo->getStatus() == 1) {
    var_dump($recurrent);
}
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
$card = $cielo->payWithCreditCard([
    "MerchantOrderId" => "2014111703",
    "Customer" => [
        "Name" => "Comprador crédito simples"
    ],
    "Payment" => [
        "Type" => "CreditCard",
        "Amount" => 15700,
        "Installments" => 1,
        "SoftDescriptor" => "123456789ABCD",
        "Capture" => true,
        "CreditCard" => [
            "CardNumber" => "1234123412341231",
            "Holder" => "Teste Holder",
            "ExpirationDate" => "12/2030",
            "SecurityCode" => "123",
            "Brand" => "Visa",
            "SaveCard" => true
        ]
    ]
]);

var_dump($cielo->getTid());

var_dump($cielo->getPaymentId());

var_dump($cielo->getMessage());

var_dump($card);
```

### Creating a recurring payment
```php
/**
 * Recurring payment
 */
$payRecurrent = $cielo->scheduledRecurrence([
    "MerchantOrderId" => "2014113245231706",
    "Customer" => [
        "Name" => "Comprador rec programada"
    ],
    "Payment" => [
        "Type" => 'CreditCard',
        "Amount" => 15700, // 157,00
        "Installments" => 1,
        "SoftDescriptor" => "Your Company",
        "Capture" => true,
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

var_dump($cielo->getMessage());

if ($cielo->confirmed()) {
    var_dump($payRecurrent);
}
```

### Creating Tokenized Card

```php
$tokenized = $cielo->creatingTokenizedCard([
    "CustomerName" => "Comprador Teste Cielo",
    "CardNumber" => "4929756094783682",
    "Holder" => "Comprador T Cielo",
    "ExpirationDate" => "08/2021",
    "Brand" => "Visa"
]);

if (!empty($tokenized->CardToken)) {
    var_dump($tokenized->CardToken);
}
```

### Developer
* [Jorge Almir Martins] - Desenvolvedor da bíblioteca

License
----

MIT
