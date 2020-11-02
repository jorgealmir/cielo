<?php

namespace Src;

use Cielo\API30\Ecommerce\Environment;
use Cielo\API30\Merchant;
use Cielo\API30\Ecommerce\Sale;
use Cielo\API30\Ecommerce\Payment;
use Cielo\API30\Ecommerce\CreditCard;
use Cielo\API30\Ecommerce\CieloEcommerce;
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
    
    /**
     * Pagamento com cartão de crédito
     * @param string $order
     */
    public function creditCard(string $order, $amount, $cvv, $brand, $expirationDate, $cardNumber, $holder) 
    {
        $sale = new Sale($order);
        
//        $customer = $sale->customer('Fulano de Tal');
        
        $payment = $sale->payment($amount);
        
        $payment->setCapture(1);
        
        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
            ->creditCard($cvv, $brand)
            ->setExpirationDate($expirationDate)
            ->setCardNumber($cardNumber)
            ->setHolder($holder
        );
        
        try {
            $retSale = (new CieloEcommerce($this->merchant, $this->environment))->createSale($sale);
            
            $this->setMessage(
                $retSale->getPayment()->getStatus(),
                $retSale->getPayment()->getReturnCode(), 
                $retSale->getPayment()->getTid()
            );
        } catch (CieloRequestException $e) {
            $err = $e->getCieloError()->getCode();
            $this->setError($err);
        }
    }
}
