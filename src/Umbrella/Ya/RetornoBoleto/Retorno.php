<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\IDetail;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\IHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\ITrailer;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

class Retorno implements IRetorno
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