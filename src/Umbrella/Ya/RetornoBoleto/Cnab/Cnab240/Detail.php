<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabDetailInterface;

class Detail extends AbstractCnab240 implements Cnab240Interface, CnabDetailInterface
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

    /**
     * @param string $numRegistroLote
     */
    public function setNumRegistroLote($numRegistroLote)
    {
        $this->numRegistroLote = $numRegistroLote;
        return $this;
    }

    /**
     * @param string $segmento
     */
    public function setSegmento($segmento)
    {
        $this->segmento = $segmento;
        return $this;
    }

    /**
     * @param string $tipoMovimento
     */
    public function setTipoMovimento($tipoMovimento)
    {
        $this->tipoMovimento = $tipoMovimento;
        return $this;
    }

    /**
     * @param string $codMovimento
     */
    public function setCodMovimento($codMovimento)
    {
        $this->codMovimento = $codMovimento;
        return $this;
    }

    /**
     * @param string $codBarras
     */
    public function setCodBarras($codBarras)
    {
        $this->codBarras = $codBarras;
        return $this;
    }

    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }

    public function setDataPagamento($dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
        return $this;
    }

    /**
     * @param string $valorTitulo
     */
    public function setValorTitulo($valorTitulo)
    {
        $this->valorTitulo = $valorTitulo;
        return $this;
    }

    /**
     * @param string $desconto
     */
    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
        return $this;
    }

    /**
     * @param string $acrescimos
     */
    public function setAcrescimos($acrescimos)
    {
        $this->acrescimos = $acrescimos;
        return $this;
    }

    /**
     * @param string $valorPagamento
     */
    public function setValorPagamento($valorPagamento)
    {
        $this->valorPagamento = $valorPagamento;
        return $this;
    }

    /**
     * @param string $quantidadeMoeda
     */
    public function setQuantidadeMoeda($quantidadeMoeda)
    {
        $this->quantidadeMoeda = $quantidadeMoeda;
        return $this;
    }

    /**
     * @param string $referenciaSacado
     */
    public function setReferenciaSacado($referenciaSacado)
    {
        $this->referenciaSacado = $referenciaSacado;
        return $this;
    }

    /**
     * @param string $nossoNumero
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    /**
     * @param string $codMoeda
     */
    public function setCodMoeda($codMoeda)
    {
        $this->codMoeda = $codMoeda;
        return $this;
    }
}
