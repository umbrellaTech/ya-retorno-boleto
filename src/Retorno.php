<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabTrailerInterface;

/**
 * Classe que representa um arquivo de retorno genérico.
 */
class Retorno implements RetornoInterface
{
    /**
     * @var CnabHeaderInterface
     */
    protected $header;

    /**
     * @var VectorInterface
     */
    protected $lotes;

    /**
     * @var CnabTrailerInterface
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
     * @param LoteInterface $lote
     * @return Retorno
     */
    public function addLote(LoteInterface $lote)
    {
        $this->lotes->add($lote);
        return $this;
    }

    /**
     * Remove um lote.
     * @param LoteInterface $lote
     * @return Retorno
     */
    public function removeLote(LoteInterface $lote)
    {
        $this->lotes->remove($lote);
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
     * Define o trailer do arquivo.
     * @param CnabTrailerInterface $trailer
     */
    public function setTrailer(CnabTrailerInterface $trailer)
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
