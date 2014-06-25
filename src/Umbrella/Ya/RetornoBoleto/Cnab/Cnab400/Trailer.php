<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400;

use Easy\Collections\ArrayList;
use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cobranca;

class Trailer implements ITrailer
{
    protected $registro;
    protected $retorno;
    protected $tipoRegistro;
    protected $sequencial;

    /**
     * @var Banco
     */
    protected $banco;

    /**
     * @var Cobranca
     */
    protected $simples;

    /**
     * @var Cobranca
     */
    protected $vinculada;

    /**
     * @var Cobranca
     */
    protected $caucionada;

    /**
     * @var Cobranca
     */
    protected $vendor;

    /**
     * @var Cobranca
     */
    protected $descontada;

    /**
     *
     * @var IVector
     */
    protected $brancos;

    public function __construct()
    {
        $this->brancos = new ArrayList();
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function getRetorno()
    {
        return $this->retorno;
    }

    public function getTipoRegistro()
    {
        return $this->tipoRegistro;
    }

    public function getSequencial()
    {
        return $this->sequencial;
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function getSimples()
    {
        return $this->simples;
    }

    public function getVinculada()
    {
        return $this->vinculada;
    }

    public function getCaucionada()
    {
        return $this->caucionada;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function getDescontada()
    {
        return $this->descontada;
    }

    public function setRegistro($registro)
    {
        $this->registro = $registro;
        return $this;
    }

    public function setRetorno($retorno)
    {
        $this->retorno = $retorno;
        return $this;
    }

    public function setTipoRegistro($tipoRegistro)
    {
        $this->tipoRegistro = $tipoRegistro;
        return $this;
    }

    public function setSequencial($sequencial)
    {
        $this->sequencial = $sequencial;
        return $this;
    }

    public function setBanco(Banco $banco)
    {
        $this->banco = $banco;
        return $this;
    }

    public function setSimples(Cobranca $simples)
    {
        $this->simples = $simples;
        return $this;
    }

    public function setVinculada(Cobranca $vinculada)
    {
        $this->vinculada = $vinculada;
        return $this;
    }

    public function setCaucionada(Cobranca $caucionada)
    {
        $this->caucionada = $caucionada;
        return $this;
    }

    public function setVendor(Cobranca $vendor)
    {
        $this->vendor = $vendor;
        return $this;
    }

    public function setDescontada(Cobranca $descontada)
    {
        $this->descontada = $descontada;
        return $this;
    }

    public function getBrancos()
    {
        return $this->brancos;
    }

    public function setBrancos($brancos)
    {
        $this->brancos = $brancos;
        return $this;
    }

    public function addBranco($zeros)
    {
        $this->brancos->add($zeros);
        return $this;
    }

    public function removeBranco($zeros)
    {
        $this->brancos->remove($zeros);
        return $this;
    }
}