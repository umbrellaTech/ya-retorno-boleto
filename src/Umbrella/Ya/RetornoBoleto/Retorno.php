<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Easy\Collections\IVector;

class Retorno implements IRetorno
{
    protected $header;

    /**
     * @var IVector
     */
    protected $details;
    protected $trailer;

    public function __construct()
    {
        $this->details = new ArrayList();
    }

    public function addDetail(IDetail $detail)
    {
        $this->details->add($detail);
        return $this;
    }

    public function removeDetail(IDetail $detail)
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

    public function setHeader(IHeader $header)
    {
        $this->header = $header;
    }

    public function setDetails(IVector $details)
    {
        $this->details = $details;
    }

    public function setTrailer(ITrailer $trailer)
    {
        $this->trailer = $trailer;
    }
}