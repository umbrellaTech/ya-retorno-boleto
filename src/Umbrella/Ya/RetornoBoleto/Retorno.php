<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

/**
 * Classe que representa um arquivo de retorno genérico.
 */
class Retorno implements IRetorno
{
    /**
     * @var ICnabHeader
     */
    protected $header;

    /**
     * @var VectorInterface
     */
    protected $lotes;

    /**
     * @var ICnabTrailer
     */
    protected $trailer;

    /**
     * Inicializa uma instância da classe Retorno.
     */
    public function __construct()
    {
        $this->lotes = new ArrayList();
    }

    /**
     * Adiciona um lote.
     * @param ILote $lote
     * @return Retorno
     */
    public function addLote(ILote $lote)
    {
        $this->lotes->add($lote);
        return $this;
    }

    /**
     * Remove um lote.
     * @param ILote $lote
     * @return Retorno
     */
    public function removeLote(ILote $lote)
    {
        $this->lotes->remove($lote);
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
     * Define o trailer do arquivo.
     * @param ICnabTrailer $trailer
     */
    public function setTrailer(ICnabTrailer $trailer)
    {
        $this->trailer = $trailer;
    }

    /**
     * Recupera todos os lotes do arquivo.
     * @return VectorInterface
     */
    public function getLotes()
    {
        return $this->lotes;
    }

    /**
     * Define todos os lotes do arquivo.
     * @param VectorInterface $lotes
     * @return Retorno
     */
    public function setLotes(VectorInterface $lotes)
    {
        $this->lotes = $lotes;
        return $this;
    }
}