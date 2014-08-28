<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;

class HeaderLote extends AbstractHeader implements Cnab240Interface, CnabHeaderInterface
{
    protected $operacao;
    protected $servico;
    protected $formaLancamento;

    /**
     *
     * @var VectorInterface
     */
    protected $mensagens;

    public function __construct()
    {
        $this->mensagens = new ArrayList();
        parent::__construct();
    }

    public function getOperacao()
    {
        return $this->operacao;
    }

    public function getServico()
    {
        return $this->servico;
    }

    public function getFormaLancamento()
    {
        return $this->formaLancamento;
    }

    public function getMensagens()
    {
        return $this->mensagens;
    }

    /**
     * @param string $operacao
     */
    public function setOperacao($operacao)
    {
        $this->operacao = $operacao;
        return $this;
    }

    /**
     * @param string $servico
     */
    public function setServico($servico)
    {
        $this->servico = $servico;
        return $this;
    }

    /**
     * @param string $formaLancamento
     */
    public function setFormaLancamento($formaLancamento)
    {
        $this->formaLancamento = $formaLancamento;
        return $this;
    }

    public function setMensagens(VectorInterface $mensagens)
    {
        $this->mensagens = $mensagens;
        return $this;
    }

    /**
     * @param string $mensagem
     */
    public function addMensagem($mensagem)
    {
        $trim = trim($mensagem);
        if (!empty($trim)) {
            $this->cnabs->add($mensagem);
        }
        return $this;
    }

    public function removeMensagem($mensagem)
    {
        $this->cnabs->remove($mensagem);
        return $this;
    }
}
