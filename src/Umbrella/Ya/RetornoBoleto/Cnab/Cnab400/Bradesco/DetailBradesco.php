<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Bradesco;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Header;

class DetailBradesco extends \Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Detail
{
    /**
     * @var int
     */
    protected $nossoNumero;

    /**
     * @var int
     */
    protected $idRateioCredito;

    /**
     * @var int
     */
    protected $idOcorrencia;

    /**
     * @var int
     */
    protected $numDocumento;

    /**
     * @var float
     */
    protected $despCobranca;

    /**
     * @var float
     */
    protected $jurosAtraso;

    /**
     * @var string
     */
    protected $motivoCodOcorrencia;

    /**
     * @var int
     */
    protected $numCartorio;

    /**
     * @var int
     */
    protected $numProtocolo;

    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    public function getIdRateioCredito()
    {
        return $this->idRateioCredito;
    }

    public function getIdOcorrencia()
    {
        return $this->idOcorrencia;
    }

    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    public function getDespCobranca()
    {
        return $this->despCobranca;
    }

    public function getJurosAtraso()
    {
        return $this->jurosAtraso;
    }

    public function getMotivoCodOcorrencia()
    {
        return $this->motivoCodOcorrencia;
    }

    public function getNumCartorio()
    {
        return $this->numCartorio;
    }

    public function getNumProtocolo()
    {
        return $this->numProtocolo;
    }

    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    public function setIdRateioCredito($idRateioCredito)
    {
        $this->idRateioCredito = $idRateioCredito;
        return $this;
    }

    public function setIdOcorrencia($idOcorrencia)
    {
        $this->idOcorrencia = $idOcorrencia;
        return $this;
    }

    public function setNumDocumento($numDocumento)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    public function setDespCobranca($despCobranca)
    {
        $this->despCobranca = $despCobranca;
        return $this;
    }

    public function setJurosAtraso($jurosAtraso)
    {
        $this->jurosAtraso = $jurosAtraso;
        return $this;
    }

    public function setMotivoCodOcorrencia($motivoCodOcorrencia)
    {
        $this->motivoCodOcorrencia = $motivoCodOcorrencia;
        return $this;
    }

    public function setNumCartorio($numCartorio)
    {
        $this->numCartorio = $numCartorio;
        return $this;
    }

    public function setNumProtocolo($numProtocolo)
    {
        $this->numProtocolo = $numProtocolo;
        return $this;
    }
}