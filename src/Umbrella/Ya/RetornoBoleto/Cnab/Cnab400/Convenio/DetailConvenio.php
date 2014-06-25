<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio;

use Easy\Collections\ArrayList;
use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Detail;

class DetailConvenio extends Detail implements IDetailConvenio
{
    protected $convenio;
    protected $controle;
    protected $nossoNumero;
    protected $dvNossoNumero;
    protected $tipoCobranca;
    protected $tipoCobrancaCmd72;
    protected $diasCalculo;
    protected $natureza;
    protected $variacaoCarteira;
    protected $contaCaucao;
    protected $confirmacao;
    protected $prefixoTitulo;

    /**
     *
     * @var IVector
     */
    protected $usoBanco;

    public function __construct()
    {
        $this->usoBanco = new ArrayList();
    }

    public function getConvenio()
    {
        return $this->convenio;
    }

    public function getControle()
    {
        return $this->controle;
    }

    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    public function getDvNossoNumero()
    {
        return $this->dvNossoNumero;
    }

    public function getTipoCobranca()
    {
        return $this->tipoCobranca;
    }

    public function getTipoCobrancaCmd72()
    {
        return $this->tipoCobrancaCmd72;
    }

    public function getDiasCalculo()
    {
        return $this->diasCalculo;
    }

    public function getNatureza()
    {
        return $this->natureza;
    }

    public function getVariacaoCarteira()
    {
        return $this->variacaoCarteira;
    }

    public function getContaCaucao()
    {
        return $this->contaCaucao;
    }

    public function getConfirmacao()
    {
        return $this->confirmacao;
    }

    public function getUsoBanco()
    {
        return $this->usoBanco;
    }

    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

    public function setControle($controle)
    {
        $this->controle = $controle;
        return $this;
    }

    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    public function setDvNossoNumero($dvNossoNumero)
    {
        $this->dvNossoNumero = $dvNossoNumero;
        return $this;
    }

    public function setTipoCobranca($tipoCobranca)
    {
        $this->tipoCobranca = $tipoCobranca;
        return $this;
    }

    public function setTipoCobrancaCmd72($tipoCobrancaCmd72)
    {
        $this->tipoCobrancaCmd72 = $tipoCobrancaCmd72;
        return $this;
    }

    public function setDiasCalculo($diasCalculo)
    {
        $this->diasCalculo = $diasCalculo;
        return $this;
    }

    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
        return $this;
    }

    public function setVariacaoCarteira($variacaoCarteira)
    {
        $this->variacaoCarteira = $variacaoCarteira;
        return $this;
    }

    public function setContaCaucao($contaCaucao)
    {
        $this->contaCaucao = $contaCaucao;
        return $this;
    }

    public function setConfirmacao($confirmacao)
    {
        $this->confirmacao = $confirmacao;
        return $this;
    }

    public function setUsoBanco(IVector $usoBanco)
    {
        $this->usoBanco = $usoBanco;
        return $this;
    }

    public function addUsoBanco($usoBanco)
    {
        $trim = trim($usoBanco);
        if (!empty($trim)) {
            $this->usoBanco->add($usoBanco);
        }

        return $this;
    }

    public function removeUsoBanco($usoBanco)
    {
        $this->usoBanco->remove($usoBanco);
        return $this;
    }

    public function getPrefixoTitulo()
    {
        return $this->prefixoTitulo;
    }

    public function setPrefixoTitulo($prefixoTitulo)
    {
        $this->prefixoTitulo = $prefixoTitulo;
        return $this;
    }
}