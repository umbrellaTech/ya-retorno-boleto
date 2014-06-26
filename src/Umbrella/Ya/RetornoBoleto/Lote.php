<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

class Lote implements ILote
{
    /**
     *
     * @var ICnabHeader
     */
    protected $header;

    /**
     * @var IVector
     */
    protected $details;

    /**
     *
     * @var ICnabTrailer
     */
    protected $trailer;

    public function __construct()
    {
        $this->details = new ArrayList();
    }

    public function addDetail(ICnabDetail $detail)
    {
        $this->details->add($detail);
        return $this;
    }

    public function removeDetail(ICnabDetail $detail)
    {
        $this->details->remove($detail);
        return $this;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function getTrailer()
    {
        return $this->trailer;
    }

    public function setHeader(ICnabHeader $header)
    {
        $this->header = $header;
    }

    public function setDetails(IVector $details)
    {
        $this->details = $details;
    }

    public function setTrailer(ICnabTrailer $trailer)
    {
        $this->trailer = $trailer;
    }
}