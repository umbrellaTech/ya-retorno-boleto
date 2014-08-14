<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab150;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;

class Detail extends AbstractCnab150 implements ICnab150, ICnabDetail
{
    /**
     *
     * @var DateTime
     */
    protected $dataPagamento;

    /**
     *
     * @var DateTime
     */
    protected $dataCredito;
    protected $valorTitulo;
    protected $valorPagamento;
    protected $valorRecebido;
    protected $valorTarifa;
    protected $codigoAgenciaArrecadadora;
    protected $formaArrecadacao;
    protected $numeroAutenticacao;
    protected $formaPagamento;
    protected $numeroSequencial;

    public function getNumeroSequencial()
    {
        return $this->numeroSequencial;
    }

    public function setNumeroSequencial($numeroSequencial)
    {
        $this->numeroSequencial = $numeroSequencial;
        return $this;
    }

    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    public function getDataCredito()
    {
        return $this->dataCredito;
    }

    public function getValorTitulo()
    {
        return $this->valorTitulo;
    }

    public function getValorPagamento()
    {
        return $this->valorPagamento;
    }

    public function getValorRecebido()
    {
        return $this->valorRecebido;
    }

    public function getValorTarifa()
    {
        return $this->valorTarifa;
    }

    public function getCodigoAgenciaArrecadadora()
    {
        return $this->codigoAgenciaArrecadadora;
    }

    public function getFormaArrecadacao()
    {
        return $this->formaArrecadacao;
    }

    public function getNumeroAutenticacao()
    {
        return $this->numeroAutenticacao;
    }

    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    public function setDataPagamento(DateTime $dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
        return $this;
    }

    public function setDataCredito(DateTime $dataCredito)
    {
        $this->dataCredito = $dataCredito;
        return $this;
    }

    public function setValorTitulo($valorTitulo)
    {
        $this->valorTitulo = $valorTitulo;
        return $this;
    }

    public function setValorPagamento($valorPagamento)
    {
        $this->valorPagamento = $valorPagamento;
        return $this;
    }

    public function setValorRecebido($valorRecebido)
    {
        $this->valorRecebido = $valorRecebido;
        return $this;
    }

    public function setValorTarifa($valorTarifa)
    {
        $this->valorTarifa = $valorTarifa;
        return $this;
    }

    public function setCodigoAgenciaArrecadadora($codigoAgenciaArrecadadora)
    {
        $this->codigoAgenciaArrecadadora = $codigoAgenciaArrecadadora;
        return $this;
    }

    public function setFormaArrecadacao($formaArrecadacao)
    {
        $this->formaArrecadacao = $formaArrecadacao;
        return $this;
    }

    public function setNumeroAutenticacao($numeroAutenticacao)
    {
        $this->numeroAutenticacao = $numeroAutenticacao;
        return $this;
    }

    public function setFormaPagamento($formaPagamento)
    {
        $this->formaPagamento = $formaPagamento;
        return $this;
    }
}