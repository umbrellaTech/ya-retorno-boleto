<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

interface ILote
{

    /**
     * @return ICnabHeader
     */
    public function getHeader();

    /**
     * @return IVector
     */
    public function getDetails();

    /**
     * @return ICnabTrailer
     */
    public function getTrailer();

    /**
     * @return Lote
     */
    public function addDetail(ICnabDetail $detail);

    /**
     * @return Lote
     */
    public function removeDetail(ICnabDetail $detail);

    /**
     * @return void
     */
    public function setHeader(ICnabHeader $header);

    /**
     * @return void
     */
    public function setDetails(IVector $details);

    /**
     * @return void
     */
    public function setTrailer(ICnabTrailer $trailer);
}