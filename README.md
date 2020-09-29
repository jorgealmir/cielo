# Integração com a Cielo

Esta bíblioteca possui funções que fazem a integração com a Cielo

Para instalar a bíblioteca, execute o seguinte comando:

``` sh
composer require ja-martins/cielo
```

Para usar a biblioteca, basta usar um require para que o composer carregue automaticamente, crie a classe e chame o método:
``` sh
<? php

require __DIR__ . '/vendor/autoload.php';

use Source\App\Cielo;

$cielo = new Cielo(
    'merchantId',
    'merchantKey',
    "true = Production/false = Sandbox" 
);

// Cria o cartão na Cielo
$createCard = $cielo->createCreditCard(
    "Nome do usuário do cartão", 
    "Número do cartão (Sem mascara)",
    "Nome do usuário do cartão (Como esta no cartão)", 
    "Data do vencimento do cartão (mm/yyyy)", 
    "Bandeira do cartão"
);

// Tratamento do retorno do método
if (!empty($createCard->Message)) {
    echo "Mensagem: {$createCard->Message}";
} else {
    var_dump($createCard);
}



// Consulta o cartão na Cielo
$queryCard = $cielo->getCreditCard("cardToken");

// Tratamento do retorno do método
if (empty($queryCard)) {
    echo 'Cartão não foi encontrado';
} else {
    var_dump($queryCard);
}



// Consulta dados do cartão de crédito
$queryCardData = $cielo->getCreditCardData("Número do cartão");

// Retorno do método
var_dump($queryCardData);



// Requisição de pagamento
$paymentRequest = $cielo->paymentRequest(
    "Nome do vendedor", // Não poderá ser maior que 13 caracteres
    "Número do Pedido", 
    "Valor", 
    "CardToken",
    "Número de parcelas",   // default 1
    "Captura true/false",   // default true
    "Recorrente true/false" // default true
);

// Tratamento do retorno do método
if (! $cielo->transactionStatusPayment($paymentRequest)) {
    echo $cielo->getMessage();
} else {
    var_dump($paymentRequest);
}
```

Para usar uma base de dados inclua no arquivo Config.php o seguinte:

``` sh
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "datalayer_example",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);
```

E siga os exemplos em:
``` sh
https://packagist.org/packages/coffeecode/datalayer
```

### Developer
* [Jorge Almir Martins] - Desenvolvedor da bíblioteca

License
----

MIT
