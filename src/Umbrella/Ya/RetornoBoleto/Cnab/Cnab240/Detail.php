<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;

class Detail extends AbstractCnab240 implements ICnab240, ICnabDetail
{
    protected $numRegistroLote;
    protected $segmento;
    protected $tipoMovimento;
    protected $codMovimento;
    protected $codBarras;

    /**
     *
     * @var DateTime
     */
    protected $dataVencimento;

    /**
     *
     * @var DateTime
     */
    protected $dataPagamento;
    protected $valorTitulo;
    protected $desconto;
    protected $acrescimos;
    protected $valorPagamento;
    protected $quantidadeMoeda;
    protected $referenciaSacado;
    protected $nossoNumero;
    protected $codMoeda;

    public function getNumRegistroLote()
    {
        return $this->numRegistroLote;
    }

    public function getSegmento()
    {
        return $this->segmento;
    }

    public function getTipoMovimento()
    {
        return $this->tipoMovimento;
    }

    public function getCodMovimento()
    {
        return $this->codMovimento;
    }

    public function getCodBarras()
    {
        return $this->codBarras;
    }

    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    public function getValorTitulo()
    {
        return $this->valorTitulo;
    }

    public function getDesconto()
    {
        return $this->desconto;
    }

    public function getAcrescimos()
    {
        return $this->acrescimos;
    }

    public function getValorPagamento()
    {
        return $this->valorPagamento;
    }

    public function getQuantidadeMoeda()
    {
        return $this->quantidadeMoeda;
    }

    public function getReferenciaSacado()
    {
        return $this->referenciaSacado;
    }

    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    public function getCodMoeda()
    {
        return $this->codMoeda;
    }

    public function setNumRegistroLote($numRegistroLote)
    {
        $this->numRegistroLote = $numRegistroLote;
        return $this;
    }

    public function setSegmento($segmento)
    {
        $this->segmento = $segmento;
        return $this;
    }

    public function setTipoMovimento($tipoMovimento)
    {
        $this->tipoMovimento = $tipoMovimento;
        return $this;
    }

    public function setCodMovimento($codMovimento)
    {
        $this->codMovimento = $codMovimento;
        return $this;
    }

    public function setCodBarras($codBarras)
    {
        $this->codBarras = $codBarras;
        return $this;
    }

    public function setDataVencimento(DateTime $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }

    public function setDataPagamento(DateTime $dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
        return $this;
    }

    public function setValorTitulo($valorTitulo)
    {
        $this->valorTitulo = $valorTitulo;
        return $this;
    }

    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
        return $this;
    }

    public function setAcrescimos($acrescimos)
    {
        $this->acrescimos = $acrescimos;
        return $this;
    }

    public function setValorPagamento($valorPagamento)
    {
        $this->valorPagamento = $valorPagamento;
        return $this;
    }

    public function setQuantidadeMoeda($quantidadeMoeda)
    {
        $this->quantidadeMoeda = $quantidadeMoeda;
        return $this;
    }

    public function setReferenciaSacado($referenciaSacado)
    {
        $this->referenciaSacado = $referenciaSacado;
        return $this;
    }

    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    public function setCodMoeda($codMoeda)
    {
        $this->codMoeda = $codMoeda;
        return $this;
    }
}