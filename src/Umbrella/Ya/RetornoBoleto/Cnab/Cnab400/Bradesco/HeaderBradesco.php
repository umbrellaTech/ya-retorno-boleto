<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Bradesco;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Header;

class HeaderBradesco extends Header
{
    /**
     * @var DateTime 
     */
    protected $densidadeGravacao;

    /**
     * @var int
     */
    protected $numAvisoBancario;

    /**
     * @var DateTime 
     */
    protected $dataCredito;

    public function getDensidadeGravacao()
    {
        return $this->densidadeGravacao;
    }

    public function getNumAvisoBancario()
    {
        return $this->numAvisoBancario;
    }

    public function getDataCredito()
    {
        return $this->dataCredito;
    }

    public function setDensidadeGravacao(DateTime $densidadeGravacao)
    {
        $this->densidadeGravacao = $densidadeGravacao;
        return $this;
    }

    public function setNumAvisoBancario($numAvisoBancario)
    {
        $this->numAvisoBancario = $numAvisoBancario;
        return $this;
    }

    public function setDataCredito(DateTime $dataCredito)
    {
        $this->dataCredito = $dataCredito;
        return $this;
    }
}
