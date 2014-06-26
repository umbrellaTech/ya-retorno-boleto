<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

class Trailer extends AbstractTrailer implements ICnab240, ICnabTrailer
{
    protected $quantidadeLotes;
    protected $quantidadeRegistros;
    protected $quantidadeContasConc;

    public function getQuantidadeLotes()
    {
        return $this->quantidadeLotes;
    }

    public function getQuantidadeRegistros()
    {
        return $this->quantidadeRegistros;
    }

    public function getQuantidadeContasConc()
    {
        return $this->quantidadeContasConc;
    }

    public function setQuantidadeLotes($quantidadeLotes)
    {
        $this->quantidadeLotes = $quantidadeLotes;
        return $this;
    }

    public function setQuantidadeRegistros($quantidadeRegistros)
    {
        $this->quantidadeRegistros = $quantidadeRegistros;
        return $this;
    }

    public function setQuantidadeContasConc($quantidadeContasConc)
    {
        $this->quantidadeContasConc = $quantidadeContasConc;
        return $this;
    }
}