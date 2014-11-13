<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabDetailInterface;

class Detail extends AbstractCnab240 implements CnabDetailInterface
{
    protected $numRegistroLote;
    protected $segmento;
    protected $tipoMovimento;
    protected $codMovimento;
    protected $codBarras;
    protected $carteira;
    protected $numeroDocumento;
    protected $numeroContrato;
    protected $valorTarifa;

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
    protected $valorPagamento;
    protected $quantidadeMoeda;
    protected $referenciaSacado;
    protected $nossoNumero;
    protected $codMoeda;

    /**
     * @var float
     */
    protected $outrasDespesas;

    /**
     * @var float
     */
    protected $outrosCreditos;

    /**
     * @var DateTime
     */
    protected $dataOcorrencia;

    /**
     * @var DateTime
     */
    protected $dataCredito;

    /**
     * @var DadosTitulo
     */
    protected $dadosTitulo;

    /**
     * @return mixed
     */
    public function getCarteira()
    {
        return $this->carteira;
    }

    /**
     * @param mixed $carteira
     * @return $this
     */
    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodBarras()
    {
        return $this->codBarras;
    }

    /**
     * @param mixed $codBarras
     * @return $this
     */
    public function setCodBarras($codBarras)
    {
        $this->codBarras = $codBarras;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodMoeda()
    {
        return $this->codMoeda;
    }

    /**
     * @param mixed $codMoeda
     * @return $this
     */
    public function setCodMoeda($codMoeda)
    {
        $this->codMoeda = $codMoeda;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodMovimento()
    {
        return $this->codMovimento;
    }

    /**
     * @param mixed $codMovimento
     * @return $this
     */
    public function setCodMovimento($codMovimento)
    {
        $this->codMovimento = $codMovimento;
        return $this;
    }

    /**
     * @return DadosTitulo
     */
    public function getDadosTitulo()
    {
        return $this->dadosTitulo;
    }

    /**
     * @param DadosTitulo $dadosTitulo
     * @return $this
     */
    public function setDadosTitulo($dadosTitulo)
    {
        $this->dadosTitulo = $dadosTitulo;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    /**
     * @param DateTime $dataPagamento
     * @return $this
     */
    public function setDataPagamento($dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * @param DateTime $dataVencimento
     * @return $this
     */
    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * @param mixed $nossoNumero
     * @return $this
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumRegistroLote()
    {
        return $this->numRegistroLote;
    }

    /**
     * @param mixed $numRegistroLote
     * @return $this
     */
    public function setNumRegistroLote($numRegistroLote)
    {
        $this->numRegistroLote = $numRegistroLote;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumeroContrato()
    {
        return $this->numeroContrato;
    }

    /**
     * @param mixed $numeroContrato
     * @return $this
     */
    public function setNumeroContrato($numeroContrato)
    {
        $this->numeroContrato = $numeroContrato;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * @param mixed $numeroDocumento
     * @return $this
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantidadeMoeda()
    {
        return $this->quantidadeMoeda;
    }

    /**
     * @param mixed $quantidadeMoeda
     * @return $this
     */
    public function setQuantidadeMoeda($quantidadeMoeda)
    {
        $this->quantidadeMoeda = $quantidadeMoeda;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferenciaSacado()
    {
        return $this->referenciaSacado;
    }

    /**
     * @param mixed $referenciaSacado
     * @return $this
     */
    public function setReferenciaSacado($referenciaSacado)
    {
        $this->referenciaSacado = $referenciaSacado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSegmento()
    {
        return $this->segmento;
    }

    /**
     * @param mixed $segmento
     * @return $this
     */
    public function setSegmento($segmento)
    {
        $this->segmento = $segmento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoMovimento()
    {
        return $this->tipoMovimento;
    }

    /**
     * @param mixed $tipoMovimento
     * @return $this
     */
    public function setTipoMovimento($tipoMovimento)
    {
        $this->tipoMovimento = $tipoMovimento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorPagamento()
    {
        return $this->valorPagamento;
    }

    /**
     * @param mixed $valorPagamento
     * @return $this
     */
    public function setValorPagamento($valorPagamento)
    {
        $this->valorPagamento = $valorPagamento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorTarifa()
    {
        return $this->valorTarifa;
    }

    /**
     * @param mixed $valorTarifa
     * @return $this
     */
    public function setValorTarifa($valorTarifa)
    {
        $this->valorTarifa = $valorTarifa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorTitulo()
    {
        return $this->valorTitulo;
    }

    /**
     * @param mixed $valorTitulo
     * @return $this
     */
    public function setValorTitulo($valorTitulo)
    {
        $this->valorTitulo = $valorTitulo;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataCredito()
    {
        return $this->dataCredito;
    }

    /**
     * @param DateTime $dataCredito
     * @return $this
     */
    public function setDataCredito(DateTime $dataCredito)
    {
        $this->dataCredito = $dataCredito;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataOcorrencia()
    {
        return $this->dataOcorrencia;
    }

    /**
     * @param DateTime $dataOcorrencia
     * @return $this
     */
    public function setDataOcorrencia(DateTime $dataOcorrencia)
    {
        $this->dataOcorrencia = $dataOcorrencia;
        return $this;
    }

    /**
     * @return float
     */
    public function getOutrasDespesas()
    {
        return $this->outrasDespesas;
    }

    /**
     * @param float $outrasDespesas
     * @return $this
     */
    public function setOutrasDespesas($outrasDespesas)
    {
        $this->outrasDespesas = $outrasDespesas;
        return $this;
    }

    /**
     * @return float
     */
    public function getOutrosCreditos()
    {
        return $this->outrosCreditos;
    }

    /**
     * @param float $outrosCreditos
     * @return $this
     */
    public function setOutrosCreditos($outrosCreditos)
    {
        $this->outrosCreditos = $outrosCreditos;
        return $this;
    }


}
