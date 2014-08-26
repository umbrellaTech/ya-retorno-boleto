<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

/**
 * Classe que representa um lote do arquivo de retorno.
 */
class Lote implements ILote
{
    /**
     * @var ICnabHeader
     */
    protected $header;

    /**
     * @var VectorInterface
     */
    protected $details;

    /**
     * @var ICnabTrailer
     */
    protected $trailer;

    /**
     * Inicializa uma instância da classe Lote.
     */
    public function __construct()
    {
        $this->details = new ArrayList();
    }

    /**
     * Adiciona um detalhe ao lote.
     * @param ICnabDetail $detail
     * @return Lote
     */
    public function addDetail(ICnabDetail $detail)
    {
        $this->details->add($detail);
        return $this;
    }

    /**
     * Remove um detalhe do lote.
     * @param ICnabDetail $detail
     * @return Lote
     */
    public function removeDetail(ICnabDetail $detail)
    {
        $this->details->remove($detail);
        return $this;
    }

    /**
     * Recupera o header do arquivo.
     * @return ICnabHeader
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Recupera os detalhes do arquivo.
     * @return VectorInterface
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Recupera o trailer do arquivo.
     * @return ICnabTrailer
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Define o header do arquivo.
     * @param ICnabHeader $header
     */
    public function setHeader(ICnabHeader $header)
    {
        $this->header = $header;
    }

    /**
     * Define os detalhes do arquivo.
     * @param VectorInterface $details
     */
    public function setDetails(VectorInterface $details)
    {
        $this->details = $details;
    }

    /**
     * Define o trailer do arquivo.
     * @param ICnabTrailer $trailer
     */
    public function setTrailer(ICnabTrailer $trailer)
    {
        $this->trailer = $trailer;
    }
}