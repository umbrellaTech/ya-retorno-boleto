<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabDetailInterface;

class DadosTitulo
{
    /**
     * @var float
     */
    protected $acrescimos;

    /**
     * @var float
     */
    protected $valorDesconto;

    /**
     * @var float
     */
    protected $valorAbatimento;

    /**
     * @var float
     */
    protected $valorIOF;

    /**
     * @var float
     */
    protected $valorPago;

    /**
     * @var float
     */
    protected $valorLiquido;

    /**
     * @return float
     */
    public function getAcrescimos()
    {
        return $this->acrescimos;
    }

    /**
     * @param float $acrescimos
     * @return $this
     */
    public function setAcrescimos($acrescimos)
    {
        $this->acrescimos = $acrescimos;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorAbatimento()
    {
        return $this->valorAbatimento;
    }

    /**
     * @param float $valorAbatimento
     * @return $this
     */
    public function setValorAbatimento($valorAbatimento)
    {
        $this->valorAbatimento = $valorAbatimento;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorDesconto()
    {
        return $this->valorDesconto;
    }

    /**
     * @param float $valorDesconto
     * @return $this
     */
    public function setValorDesconto($valorDesconto)
    {
        $this->valorDesconto = $valorDesconto;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorIOF()
    {
        return $this->valorIOF;
    }

    /**
     * @param float $valorIOF
     * @return $this
     */
    public function setValorIOF($valorIOF)
    {
        $this->valorIOF = $valorIOF;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorLiquido()
    {
        return $this->valorLiquido;
    }

    /**
     * @param float $valorLiquido
     * @return $this
     */
    public function setValorLiquido($valorLiquido)
    {
        $this->valorLiquido = $valorLiquido;
        return $this;
    }

    /**
     * @return float
     */
    public function getValorPago()
    {
        return $this->valorPago;
    }

    /**
     * @param float $valorPago
     * @return $this
     */
    public function setValorPago($valorPago)
    {
        $this->valorPago = $valorPago;
        return $this;
    }


}
