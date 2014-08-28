<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab150;

use Umbrella\Ya\RetornoBoleto\Cnab\AbstractCnab;

abstract class AbstractCnab150 extends AbstractCnab
{
    protected $codBarras;
    protected $filler;

    public function getCodBarras()
    {
        return $this->codBarras;
    }

    public function setCodBarras($codBarras)
    {
        $this->codBarras = $codBarras;
        return $this;
    }

    public function getFiller()
    {
        return $this->filler;
    }

    public function setFiller($filler)
    {
        $this->filler = $filler;
        return $this;
    }
}
