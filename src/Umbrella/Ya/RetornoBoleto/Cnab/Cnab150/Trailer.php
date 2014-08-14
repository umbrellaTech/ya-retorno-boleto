<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab150;

use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

class Trailer extends AbstractCnab150 implements ICnab150, ICnabTrailer
{
    protected $valorTotal;
    protected $quantidadeRegistros;

    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    public function getQuantidadeRegistros()
    {
        return $this->quantidadeRegistros;
    }

    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
        return $this;
    }

    public function setQuantidadeRegistros($quantidadeRegistros)
    {
        $this->quantidadeRegistros = $quantidadeRegistros;
        return $this;
    }
}