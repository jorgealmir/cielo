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

class Payment extends Message
{
    private $environment;
    private $merchant;
    
    /**
     * Inicia a classe com o ambiente selecionado
     * @param bool $sandbox
     */
    public function __construct(bool $sandbox = true) 
    {
        if ($sandbox) {
            $this->environment = Environment::sandbox();
        
            $this->merchant = new Merchant(
                CIELO_SANDBOX_MERCHANT_ID, 
                CIELO_SANDBOX_MERCHANT_KEY
            );
        } else {
            $this->environment = Environment::production();
        
            $this->merchant = new Merchant(
                CIELO_MERCHANT_ID, 
                CIELO_MERCHANT_KEY
            );
        }
    }
    
    /**
     * Pagamento com cartão de crédito
     * @param string $order
     */
    public function creditCard(string $order) 
    {
        $sale = new Sale($order);
        
//        $customer = $sale->customer('Fulano de Tal');
        
        $payment = $sale->payment(15700);
        
        $payment->setCapture(1);
        
        $payment->setType(Payment::PAYMENTTYPE_CREDITCARD)
                ->creditCard("321", CreditCard::VISA)
                ->setExpirationDate("10/202a")
                ->setCardNumber("0000000000000001")
                ->setHolder("Fulano de Tal");
        
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
