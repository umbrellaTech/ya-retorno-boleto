<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

interface ILote
{

    public function getHeader();

    public function getDetails();

    public function getTrailer();

    public function addDetail(ICnabDetail $detail);

    public function removeDetail(ICnabDetail $detail);

    public function setHeader(ICnabHeader $header);

    public function setDetails(IVector $details);

    public function setTrailer(ICnabTrailer $trailer);
}