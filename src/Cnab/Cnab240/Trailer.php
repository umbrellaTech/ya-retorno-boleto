<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use Umbrella\Ya\RetornoBoleto\Cnab\CnabTrailerInterface;

class Trailer extends AbstractTrailer implements CnabTrailerInterface
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

    /**
     * @param string $quantidadeLotes
     */
    public function setQuantidadeLotes($quantidadeLotes)
    {
        $this->quantidadeLotes = $quantidadeLotes;
        return $this;
    }

    /**
     * @param string $quantidadeRegistros
     */
    public function setQuantidadeRegistros($quantidadeRegistros)
    {
        $this->quantidadeRegistros = $quantidadeRegistros;
        return $this;
    }

    /**
     * @param string $quantidadeContasConc
     */
    public function setQuantidadeContasConc($quantidadeContasConc)
    {
        $this->quantidadeContasConc = $quantidadeContasConc;
        return $this;
    }
}
