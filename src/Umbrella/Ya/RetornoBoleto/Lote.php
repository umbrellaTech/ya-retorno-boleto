<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabDetailInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabTrailerInterface;

/**
 * Classe que representa um lote do arquivo de retorno.
 */
class Lote implements LoteInterface
{
    /**
     * @var CnabHeaderInterface
     */
    protected $header;

    /**
     * @var VectorInterface
     */
    protected $details;

    /**
     * @var CnabTrailerInterface
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
     * @param CnabDetailInterface $detail
     * @return Lote
     */
    public function addDetail(CnabDetailInterface $detail)
    {
        $this->details->add($detail);
        return $this;
    }

    /**
     * Remove um detalhe do lote.
     * @param CnabDetailInterface $detail
     * @return Lote
     */
    public function removeDetail(CnabDetailInterface $detail)
    {
        $this->details->remove($detail);
        return $this;
    }

    /**
     * Recupera o header do arquivo.
     * @return CnabHeaderInterface
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
     * @return CnabTrailerInterface
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Define o header do arquivo.
     * @param CnabHeaderInterface $header
     */
    public function setHeader(CnabHeaderInterface $header)
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
     * @param CnabTrailerInterface $trailer
     */
    public function setTrailer(CnabTrailerInterface $trailer)
    {
        $this->trailer = $trailer;
    }
}