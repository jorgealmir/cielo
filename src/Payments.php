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
    private $environment;
    private $merchant;
    
    /**
     * Inicia a classe com o ambiente selecionado
     * @param bool $sandbox
     */
    public function __construct(string $merchantId, string $merchantKey, bool $sandbox = true) 
    {
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
    
    public function tokenizingCard(array $data) 
    { 
        $card = new CreditCard();
        $card->setCustomerName($data['customerName']);
        $card->setCardNumber($data['cardNumber']);
        $card->setHolder($data['holder']);
        $card->setExpirationDate($data['expirationDate']);
        $card->setSecurityCode($data['securityCode']);
        $card->setBrand($data['brand']);
        // CardToken: 495db52c-17c8-4698-af28-98bdff5b5339

        try {
            $respCard = (new CieloEcommerce($this->merchant, $this->environment))->tokenizeCard($card);
            
            $cardToken = $respCard->getCardToken();
        
            $this->setMessage(21, "", "", $cardToken);
        } catch (CieloRequestException $e) {
            $this->setError($e->getCieloError()->getCode());
        }
    }
    
    public function payCreditCardTokenized(array $data) 
    {
        $sale = new Sale($data['order']);

        $sale->customer($data['customerName']);

        $payment = $sale->payment($data['amount']);
        
        $payment->setCapture(1);

        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
                ->creditCard($data['securityCode'], $data['brand'])
                ->setCardToken($data['cardToken']);

        try {
            $responseSale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);
            
            $this->setMessage(
                $responseSale->getPayment()->getStatus(),
                $responseSale->getPayment()->getReturnCode()
            );
            
            $this->setTid($responseSale->getPayment()->getTid());
            $this->setPaymentId($responseSale->getPayment()->getPaymentId());
            
            var_dump($responseSale);
        } catch (CieloRequestException $e) {
            $this->setError($e->getCieloError()->getCode());
        }
    }
    
    /**
     * Pagamento com Cartão de crédito
     * @param array $data
     */
    public function payCreditCard(array $data) 
    {
        $sale = new Sale($data['order']);
        
        $sale->customer($data['customerName']);
        
        $payment = $sale->payment($data['amount']);
        
        $payment->setCapture(1);
        
        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
            ->creditCard($data['securityCode'], $data['brand'])
            ->setExpirationDate($data['expirationDate'])
            ->setCardNumber($data['cardNumber'])
            ->setHolder($data['holder']
        );
        
        try {
            $retSale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);
            
            $this->setMessage(
                $retSale->getPayment()->getStatus(),
                $retSale->getPayment()->getReturnCode(), 
                $retSale->getPayment()->getTid()
            );
            
            var_dump($retSale);
        } catch (CieloRequestException $e) {
            $err = $e->getCieloError()->getCode();
            $this->setError($err);
        }
    }
    
    /**
     * Pay Recurrent
     * @param array $data
     * @return type
     */
    public function payRecurrent(array $data) {
        $sale = new Sale($data['MerchantOrderId']);

        $sale->customer($data['Customer']['Name']);

        $payment = $sale->payment($data['Payment']['Amount']);
        
        $payment->setCapture(1);

        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
            ->creditCard($data['Payment']['CreditCard']['SecurityCode'], $data['Payment']['CreditCard']['Brand'])
            ->setExpirationDate($data['Payment']['CreditCard']['ExpirationDate'])
            ->setCardNumber($data['Payment']['CreditCard']['CardNumber'])
            ->setHolder($data['Payment']['CreditCard']['Holder']);

        $payment->recurrentPayment(true)->setInterval(RecurrentPayment::INTERVAL_MONTHLY);

        try {
            $paySale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);

//            $recurrentPaymentId = $paySale->getPayment()->getPaymentId();
        
            var_dump($paySale);
            
            $this->setMessage(
                $paySale->getPayment()->getStatus(),
                $paySale->getPayment()->getReturnCode(), 
                $paySale->getPayment()->getTid()
            );
        } catch (CieloRequestException $e) {
            $this->setError($e->getCieloError()->getCode());
        }
    }
}
