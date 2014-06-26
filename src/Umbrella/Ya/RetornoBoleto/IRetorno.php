<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

interface IRetorno
{

    public function getHeader();

    public function getLotes();

    public function getTrailer();

    public function addLote(ILote $detail);

    public function removeLote(ILote $detail);

    public function setHeader(ICnabHeader $header);

    public function setTrailer(ICnabTrailer $trailer);

    public function setLotes(IVector $lote);
}