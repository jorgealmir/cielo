<?php

namespace Jamartins\Cielo;

/**
 * Description of MessageCielo
 *
 * @author Jorge
 */
class Message extends Error
{
    private $status;
    private $code;
    private $message;
    private $texto;
    private $tid;
    private $token;
    private $paymentId;
    private $cardNumber;
    private $recurrentPaymentId;
    private $error;

    /**
     * Popula a mensagem de retorno
     * @param type $code
     * @param type $message
     * @param bool $error
     */
    public function setMessage2($code, $message, bool $error = false) 
    {
        $this->code = $code;
        $this->message = $message;
        $this->error = $error;
    }
    
    public function getMessage2(): string 
    {
        if ($this->error) {
            return "Opsss: " . $this->code . " - " . $this->message;
        } else {
            
        }
    }

    /**
     * Atribuição de variáveis
     * @param type $status
     * @param type $code
     * @param type $tid
     */
    public function setMessage($status, $code) 
    {
        $this->status = $status;
        $this->code = $code;
    }
    
    /**
     * Retorna a mensagem traduzida
     * @return string
     */
    public function getMessage(): string
    {
        if (!empty($this->error)) {
            return $this->getError($this->error);
        }
        
        /*
         * Tradução do status
         */
        if ($this->status == 0) {
            $this->texto = 'Aguardando atualização de status';
        } elseif ($this->status == 1) {
            $this->texto = 'Pagamento apto a ser capturado ou definido como pago';
        } elseif ($this->status == 2) {
            $this->texto = 'Pagamento realizado com sucesso!';
        } elseif ($this->status == 3) {
            $this->texto = 'Pagamento negado pelo Autorizador';
        } elseif ($this->status == 10) {
            $this->texto = 'Pagamento cancelado';
        } elseif ($this->status == 11) {
            $this->texto = 'Pagamento cancelado após 23:59 do dia de autorização';
        } elseif ($this->status == 12) {
            $this->texto = 'Aguardando Status de instituição financeira';
        } elseif ($this->status == 13) {
            $this->texto = 'Pagamento cancelado por falha no processamento ou por ação do AF';
        } elseif ($this->status == 20) {
            $this->texto = 'Recorrência agendada';
        } elseif ($this->status == 21) {
            $this->texto = 'CardToken criado com sucesso';
        }
        
        
        /*
         * Tratamento do retorno
         */
        if ($this->status == 2) {
            return $this->texto . ' TID ' . $this->tid;
        } elseif ($this->status == 21) {
            return $this->texto . '. Token: ' . $this->token; 
        } else {
            if ($this->code == '05') {
                $this->message = 'Não Autorizado';
            } elseif ($this->code == '57') {
                $this->message = 'Cartão Expirado';
            } elseif ($this->code == '70') {
                $this->message = 'Problemas com o Cartão de Crédito';
            } elseif ($this->code == '77') {
                $this->message = 'Cartão Cancelado';
            } elseif ($this->code == '78') {
                $this->message = 'Cartão Bloqueado';
            } elseif ($this->code == '99') {
                $this->message = 'Tempo esgotado';
            }
        
            return $this->texto . '. ' . $this->message;
        }
    }
    
    public function setError(string $message) 
    {
        $this->error = $message;
    }
    
    public function setTid($value) 
    {
        $this->tid = $value;
    }
    
    public function getTid(): string
    {
        return $this->tid;
    }
    
    public function setCardNumber($value) 
    {
        $this->cardNumber = $value;
    }
    
    public function getCardNumber(): string 
    {
        return $this->cardNumber;
    }
    
    public function setToken($value) 
    {
        $this->token = $value;
    }
    
    public function getToken(): string
    {
        return $this->token;
    }
    
    public function setPaymentId($value) 
    {
        $this->paymentId = $value;
    }
    
    public function getPaymentId() 
    {
        return $this->paymentId;
    }
    
    public function setRecurrentPaymentId($value) 
    {
        $this->recurrentPaymentId = $value;
    }
    
    public function getRecurrentPaymentId() 
    {
        return $this->recurrentPaymentId;
    }
    
    public function getStatus() 
    {
        return $this->status;
    }
    
    public function confirmed(): bool 
    {
        return $this->status == 2;
    }
}
