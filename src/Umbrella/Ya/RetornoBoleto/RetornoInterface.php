<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabTrailerInterface;

interface RetornoInterface
{

    /**
     * @return CnabHeaderInterface
     */
    public function getHeader();

    /**
     * @return VectorInterface
     */
    public function getLotes();

    /**
     * @return CnabTrailerInterface
     */
    public function getTrailer();

    /**
     * @return Retorno
     */
    public function addLote(LoteInterface $detail);

    /**
     * @return Retorno
     */
    public function removeLote(LoteInterface $detail);

    /**
     * @return void
     */
    public function setHeader(CnabHeaderInterface $header);

    /**
     * @return void
     */
    public function setTrailer(CnabTrailerInterface $trailer);

    /**
     * @return Retorno
     */
    public function setLotes(VectorInterface $lote);
}