<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

interface IRetorno
{

    /**
     * @return ICnabHeader
     */
    public function getHeader();

    /**
     * @return IVector
     */
    public function getLotes();

    /**
     * @return ICnabTrailer
     */
    public function getTrailer();

    /**
     * @return Retorno
     */
    public function addLote(ILote $detail);

    /**
     * @return Retorno
     */
    public function removeLote(ILote $detail);

    /**
     * @return void
     */
    public function setHeader(ICnabHeader $header);

    /**
     * @return void
     */
    public function setTrailer(ICnabTrailer $trailer);

    /**
     * @return Retorno
     */
    public function setLotes(IVector $lote);
}