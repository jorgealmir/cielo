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
    public function getCreditCardData($cardNumber) 
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
        $seller,
        $orderId, 
        $amount, 
        $cardToken,
        $installments = 1,
        $capture = true,
        $recurrent = true
    ) {
        $this->endPoint = "/1/sales";
        
        $this->params = [
            "MerchantOrderId" => $orderId,
            "Payment" => [
                "Recurrent" => $recurrent,
                "Type" => "CreditCard",
                "Amount" => $amount,
                "Installments" => $installments,
                "SoftDescriptor" => $seller,
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
    
    public function getMessage(): string {
        return $this->message;
    }
    
    /**
     * Retorna o status da transação de pagamento
     * @param type $transaction
     * @return bool
     */
    public function transactionStatusPayment($transaction): bool 
    {
        if ($transaction->Payment->Status == 2) {
            return true;
        } else {
            $code = $transaction->Payment->ReturnCode;
            
            if ($code == '04') {
                $this->message = "$code - Operação realizada com sucesso";
            } elseif ($code == '05') {
                $this->message = "$code - Não Autorizada";
            } elseif ($code == '06') {
                $this->message = "$code - Operação realizada com sucesso";
            } elseif ($code == '57') {
                $this->message = "$code - Cartão Expirado";
            } elseif ($code == '70') {
                $this->message = "$code - Problemas com o Cartão de Crédito";
            } elseif ($code == '77') {
                $this->message = "$code - Cartão Cancelado";
            } elseif ($code == '78') {
                $this->message = "$code - Cartão Bloqueado";
            } elseif ($code == '99') {
                $this->message = "$code - Operation Successful / Time Out";
            } else {
                $this->message = "Erro não catalogado";
            }
            
            return false;
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
