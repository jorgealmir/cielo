<?php

namespace Src;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Merchant;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\RecurrentPayment;
use Cielo\API30\Ecommerce\CieloEcommerce;
use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\Request\CieloRequestException;

use Src\Message;

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


    private $environment;
    private $merchant;
    
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
        
        try {
            if ($sandbox) {
                $this->environment = Environment::sandbox();
            } else {
                $this->environment = Environment::production();
            }
        
            $this->merchant = new Merchant($merchantId, $merchantKey);
        } catch (CieloRequestException $e) {
            $this->setError($e->getCieloError()->getCode());
        }
    }
    
//    public function tokenizingCard(array $data) 
//    { 
//        $card = new CreditCard();
//        $card->setCustomerName($data['customerName']);
//        $card->setCardNumber($data['cardNumber']);
//        $card->setHolder($data['holder']);
//        $card->setExpirationDate($data['expirationDate']);
//        $card->setSecurityCode($data['securityCode']);
//        $card->setBrand($data['brand']);
//        // CardToken: 495db52c-17c8-4698-af28-98bdff5b5339
//
//        try {
//            $respCard = (new CieloEcommerce($this->merchant, $this->environment))->tokenizeCard($card);
//            
//            $cardToken = $respCard->getCardToken();
//        
//            $this->setMessage(21, "", "", $cardToken);
//        } catch (CieloRequestException $e) {
//            $this->setError($e->getCieloError()->getCode());
//        }
//    }
    
//    public function payCreditCardTokenized(array $data) 
//    {
//        $sale = new Sale($data['order']);
//
//        $sale->customer($data['customerName']);
//
//        $payment = $sale->payment($data['amount']);
//        
//        $payment->setCapture(1);
//
//        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
//            ->creditCard($data['securityCode'], $data['brand'])
//            ->setCardToken($data['cardToken']);
//
//        try {
//            $responseSale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);
//            
//            $this->setMessage(
//                $responseSale->getPayment()->getStatus(),
//                $responseSale->getPayment()->getReturnCode()
//            );
//            
//            $this->setTid($responseSale->getPayment()->getTid());
//            $this->setPaymentId($responseSale->getPayment()->getPaymentId());
//            
//            var_dump($responseSale);
//        } catch (CieloRequestException $e) {
//            $this->setError($e->getCieloError()->getCode());
//        }
//    }
    
    /**
     * Pagamento com Cartão de crédito
     * @param array $data
     */
//    public function payCreditCard(array $data) 
//    {
//        $sale = new Sale($data['order']);
//        
//        $sale->customer($data['customerName']);
//        
//        $payment = $sale->payment($data['amount']);
//        
//        $payment->setCapture(1);
//        
//        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
//            ->creditCard($data['securityCode'], $data['brand'])
//            ->setExpirationDate($data['expirationDate'])
//            ->setCardNumber($data['cardNumber'])
//            ->setHolder($data['holder'])
//            ->setSaveCard(true);
//        
//        try {
//            $retSale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);
//           
//            $token = $retSale->getPayment()->getCreditCard()->getCardToken();
//            var_dump($token);
//            
//            $this->setMessage(
//                $retSale->getPayment()->getStatus(),
//                $retSale->getPayment()->getReturnCode()
//            );
//            
//            $this->setTid($retSale->getPayment()->getTid());
//            $this->setPaymentId($retSale->getPayment()->getPaymentId());
//            
//            var_dump($retSale);
//        } catch (CieloRequestException $e) {
//            $err = $e->getCieloError()->getCode();
//            $this->setError($err);
//        }
//    }
    
    /**
     * Pay Recurrent
     * @param array $data
     * @return type
     */
//    public function payRecurrent(array $data) {
//        $sale = new Sale($data['MerchantOrderId']);
//
//        $sale->customer($data['Customer']['Name']);
//
//        $payment = $sale->payment($data['Payment']['Amount']);
//        
//        $payment->setCapture(1);
//
//        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
//            ->creditCard($data['Payment']['CreditCard']['SecurityCode'], $data['Payment']['CreditCard']['Brand'])
//            ->setExpirationDate($data['Payment']['CreditCard']['ExpirationDate'])
//            ->setCardNumber($data['Payment']['CreditCard']['CardNumber'])
//            ->setHolder($data['Payment']['CreditCard']['Holder']);
//
//        $payment->recurrentPayment(true)->setInterval(RecurrentPayment::INTERVAL_MONTHLY);
//
//        try {
//            $paySale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);
//
////            $recurrentPaymentId = $paySale->getPayment()->getPaymentId();
//        
//            var_dump($paySale);
//            
//            $this->setMessage(
//                $paySale->getPayment()->getStatus(),
//                $paySale->getPayment()->getReturnCode(), 
//                $paySale->getPayment()->getTid()
//            );
//        } catch (CieloRequestException $e) {
//            $this->setError($e->getCieloError()->getCode());
//        }
//    }
    
    
    /*
     * Sem API
     */
    
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
    
    
    
    
    /*
     * Transações com POSTs
     */
    public function payWithCreditCard(array $data) 
    {
        $this->endPoint = "/1/sales/";
        
        $this->params = $data;
        
        $this->post();
        
        $card = (array) $this->callBack;
            
        $this->setMessage(
            $card['Payment']->Status,
            $card['Payment']->ReturnCode
        );
        
        $this->setTid($card['Payment']->Tid);
        $this->setPaymentId($card['Payment']->PaymentId);
        
        return $card;
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
