<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabDetailInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabTrailerInterface;

interface LoteInterface
{

    /**
     * @return CnabHeaderInterface
     */
    public function getHeader();

    /**
     * @return VectorInterface
     */
    public function getDetails();

    /**
     * @return CnabTrailerInterface
     */
    public function getTrailer();

    /**
     * @return Lote
     */
    public function addDetail(CnabDetailInterface $detail);

    /**
     * @return Lote
     */
    public function removeDetail(CnabDetailInterface $detail);

    /**
     * @return void
     */
    public function setHeader(CnabHeaderInterface $header);

    /**
     * @return void
     */
    public function setDetails(VectorInterface $details);

    /**
     * @return void
     */
    public function setTrailer(CnabTrailerInterface $trailer);
}
