<?php

namespace Source\App;

class Cielo {
    /** @var string */
    private $merchantId;
    
    /** @var string */
    private $merchantKey;
    
    /** @var string */
    private $apiUrlQuery;
    
    /** @var string */
    private $apiUrl;
    
    /** @var string */
    private $headers;
    
    /** @var string */
    private $endPoint;
    
    /** @var string */
    private $params;
    
    /** @var string */
    private $callBack;
    
    /** @var string */
    private $message;


    /**
     * Construct
     * @param type $live
     */
    public function __construct(
        string $merchantId, 
        string $merchantKey, 
        $live = true
    ) {
        $this->merchantId = $merchantId;
        $this->merchantKey = $merchantKey;
            
        if ($live === true) {
            $this->apiUrlQuery = 'https://apiquery.cieloecommerce.cielo.com.br/';
            $this->apiUrl = 'https://api.cieloecommerce.cielo.com.br/';
        } else {
            $this->apiUrlQuery = 'https://apiquerysandbox.cieloecommerce.cielo.com.br';
            $this->apiUrl = 'https://apisandbox.cieloecommerce.cielo.com.br';
        }
        
        $this->headers = [
            "Content-Type: application/json",
            "MerchantId: {$this->merchantId}",
            "MerchantKey: {$this->merchantKey}"
        ];
    }
    
    
    /**
     * Cria um cartão de crédito
     * @param type $name
     * @param type $cardNumber
     * @param type $cardHolderName
     * @param type $cardExprirationDate
     * @param type $cardBrand
     * @return type
     */
    public function createCreditCard(
        $name, 
        $cardNumber, 
        $cardHolderName,
        $cardExprirationDate,
        $cardBrand
    ) {
        $this->endPoint = '/1/card';
        
        $this->params = [
            'CustomerName' => $name,
            'CardNumber' => $cardNumber,
            'Holder' => $cardHolderName,
            'ExpirationDate' => $cardExprirationDate,
            'Brand' => $cardBrand
        ];
        
        $this->post();
        
        return $this->callBack;
    }
    
    /**
     * Consulta cartão de crédito
     * @param type $cardToken
     * @return type
     */
    public function getCreditCard($cardToken) 
    {
        $this->endPoint = "/1/card/{$cardToken}";
        $this->get();
        return $this->callBack;
    }
    
    /**
     * Consulta dados do cartão de crédito
     * @param type $cardNumber
     * @return type
     */
    private function getCreditCardData($cardNumber) 
    {
        $number = substr($cardNumber, 1, 6);
        $this->endPoint = "/1/cardBin/{$number}";
        $this->get();
        
        return $this->callBack;
    }
    
    /**
     * Requisição de pagamento
     * @param type $orderId
     * @param type $amount
     * @param type $installments
     * @param type $cardToken
     * @param type $capture
     * @return type
     */
    public function paymentRequest(
        $orderId, 
        $amount, 
        $installments = 1,
        $cardToken,
        $capture = true
    ) {
        $this->endPoint = "/1/sales";
        
        $this->params = [
            "MerchantOrderId" => $orderId,
            "Payment" => [
                "Type" => "CreditCard",
                "Amount" => $amount,
                "Installments" => $installments,
                "SoftDescriptor" => operator(),
                "Capture" => $capture,
                "CreditCard" => [
                    "CardToken" => $cardToken
                ]
            ]
        ];
        
        $this->post();
        
        return $this->callBack;
    }
    
    /**
     * Consulta transação
     * @param type $transaction
     * @return type
     */
    public function getTransaction($transaction) 
    {
        $this->endPoint = "/1/sales/{$transaction}";
        $this->get();
        return $this->callBack;
    }
    
    /**
     * Retorna o status da transação de pagamento
     * @param type $transaction
     * @return bool
     */
    public function transactionStatusPayment($transaction): bool 
    {
        switch ($transaction->Payment->Status) {
            case 0:
                return false;
            case 1:
                return false;
            case 2:
                return true;
            case 3:
                return false;

            default:
                return false;
        }
    }
    
    /**
     * Código de retorno da requisição do pagamento
     * @param string $code
     * @return string
     */
    public function getCodePayment(string $code): string 
    {
        switch ($code) {
            case '04':
                return "$code - Operação realizada com sucesso";
            case '05':
                return "$code - Não Autorizada";
            case '06':
                return "$code - Operação realizada com sucesso";
            case '57':
                return "$code - Cartão Expirado";
            case '78':
                return "$code - Cartão Bloqueado";
            case '99':
                return "$code - Time Out";
            case '77':
                return "$code - Cartão Cancelado";
            case '70':
                return "$code - Problemas com o Cartão de Crédito";
            case '99':
                return "$code - Operation Successful / Time Out";

            default:
                return "Erro não catalogado";
        }
    }
    
    /**
     * Curl do post
     */
    private function post() 
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . $this->endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($this->params),
            CURLOPT_HTTPHEADER => $this->headers,
        ]);
        
        $this->callBack = json_decode(curl_exec($curl));

        curl_close($curl);
    }
    
    /**
     * Curl do get
     */
    private function get() 
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrlQuery . $this->endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $this->headers,
        ]);
        
        $this->callBack = json_decode(curl_exec($curl));

        curl_close($curl);
    }
}
