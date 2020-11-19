<?php

namespace Jamartins\Cielo;

class Payments extends Message
{
    private $merchantId;
    private $merchantKey;
    private $apiUrlQuery;
    private $apiUrl;
    private $headers;

    private $endPoint;
    private $params;
    private $callBack;
    private $curlError;
    
    /**
     * Inicia a classe com o ambiente selecionado
     * @param bool $sandbox
     */
    public function __construct(string $merchantId, string $merchantKey, bool $sandbox = true) 
    {
        $this->merchantId = $merchantId;
        $this->merchantKey = $merchantKey;
        
        if ($sandbox === true) {
            $this->apiUrlQuery = 'https://apiquerysandbox.cieloecommerce.cielo.com.br';
            $this->apiUrl = 'https://apisandbox.cieloecommerce.cielo.com.br';
        } else {
            $this->apiUrlQuery = 'https://apiquery.cieloecommerce.cielo.com.br/';
            $this->apiUrl = 'https://api.cieloecommerce.cielo.com.br/';
        }
        
        $this->headers = [
            "Content-Type: application/json",
            "MerchantId: {$this->merchantId}",
            "MerchantKey: {$this->merchantKey}"
        ];
    }
    
    
        
    /*
     * Transações com POSTs
     */
    public function payWithCreditCard(array $data) 
    {
        $this->endPoint = "/1/sales/";
        
        $this->params = $data;
        
        $this->post();
        
        $card = $this->callBack;
            
        $this->setMessage(
            $card->Payment->Status,
            $card->Payment->ReturnCode
        );
        
        $this->setCardNumber($card->Payment->CreditCard->CardNumber);
        $this->setTid($card->Payment->Tid);
        $this->setPaymentId($card->Payment->PaymentId);
        
        return $card;
    }
            

            
    /*
     * Transações com GETs
     */
    public function getCreditCard($cardToken) 
    {
        $this->endPoint = "/1/card/{$cardToken}";
        $this->get();
        
        return $this->callBack;
    }
    
    
        
    public function getCreditCardData($cardNumber) 
    {
        $number = substr($cardNumber, 1, 6);
        $this->endPoint = "/1/cardBin/{$number}";
        $this->get();
        
        return $this->callBack;
    }
    
    
    
    public function queryByPaymentId($paymentId) 
    {
        $this->endPoint = "/1/sales/{$paymentId}";
        
        $this->get();
        
        $pay = (array) $this->callBack;
        
        $this->setMessage($pay['Payment']->Status, "");
        
        $this->setTid($pay['Payment']->Tid);
        
        return $pay;
    }
    
    
    
    public function queryByOrderId($merchantOrderId) 
    {
        $this->endPoint = "/1/sales?merchantOrderId={$merchantOrderId}";
        
        $this->get();
        
        $order = (array) $this->callBack;
        
        $this->setMessage($order['ReasonCode'], "");
        
        return $order;
    }
    
    
    
    public function queryRecurrent($recurrentPaymentId) 
    {
        $this->endPoint = "/1/RecurrentPayment/{$recurrentPaymentId}";
        
        $this->get();
        
        $recurrent = (array) $this->callBack;
        
        $this->setMessage($recurrent['RecurrentPayment']->Status, "");
        
        return $recurrent;
    }
    
    
    
    public function scheduledRecurrence(array $data) 
    {
        $this->endPoint = "/1/sales/";
        
        $this->params = $data;
        
        $this->post();
        
        $recurrence = (array) $this->callBack;
        
        $this->setMessage(
            $recurrence['Payment']->Status, 
            $recurrence['Payment']->ReturnCode
        );
        
        $this->setTid($recurrence['Payment']->Tid);
        $this->setPaymentId($recurrence['Payment']->PaymentId);
        $this->setRecurrentPaymentId($recurrence['Payment']->RecurrentPayment->RecurrentPaymentId);
        
        return $recurrence;
    }
    
    
    
    public function creatingTokenizedCard(array $data) 
    {
        $this->endPoint = "/1/card/";
        
        $this->params = $data;
        
        $this->post();
        
        $tokenized = $this->callBack;
        
        return $tokenized;
    }
    
    
    
    public function creatingTokenizedCardOnAuthorization(array $data) 
    {
        var_dump($data);
    }
    
    
    
    /*
     * Tranzações com PUTs
     */
    public function ModifyingBuyerDataRecurrent(array $data, $recurrentPaymentId) 
    {
        $this->endPoint = "/1/RecurrentPayment/{$recurrentPaymentId}/Customer";
        
        $this->params = $data;
        
        $this->put();

        if ($this->curlError) {
            return "cURL Error #:" . $this->curlError;
        } else {
            $buyer = $this->callBack;
        
            var_dump($buyer);

            return $buyer;
        }
    }
    
    
    
    /*
     * Privaties
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
    
    private function put() 
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . $this->endPoint,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_POSTFIELDS => json_encode($this->params)
//          CURLOPT_RETURNTRANSFER => true,
//          CURLOPT_ENCODING => "",
//          CURLOPT_MAXREDIRS => 10,
//          CURLOPT_TIMEOUT => 30,
//          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
////          CURLOPT_PUT => true,  
//          CURLOPT_CUSTOMREQUEST => "PUT",
//          CURLOPT_POSTFIELDS => json_encode($this->params),
//          CURLOPT_HTTPHEADER => $this->headers,
        ]);

        $this->callBack = json_decode(curl_exec($curl));
        $this->curlError = curl_error($curl);

        curl_close($curl);
    }
    
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
