<?php

namespace Src;

use Src\Error;

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
    private $error;


    /**
     * Atribuição de variáveis
     * @param type $status
     * @param type $code
     * @param type $tid
     */
    public function setMessage($status, $code, $tid = '') 
    {
        $this->status = $status;
        $this->code = $code;
        $this->tid = $tid;
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
        }
        
        
        /*
         * Tratamento do retorno
         */
        if ($this->status == 2) {
            return $this->texto . ' TID ' . $this->tid;
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
}
