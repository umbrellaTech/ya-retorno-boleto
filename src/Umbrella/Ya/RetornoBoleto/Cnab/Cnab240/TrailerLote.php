<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;

class TrailerLote extends AbstractTrailer implements ICnab240, ICnabTrailer
{
    protected $quantidadeRegistros;
    protected $valor;
    protected $quantidadeMoedas;
    protected $numAvisoDepbito;

    public function getQuantidadeRegistros()
    {
        return $this->quantidadeRegistros;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function getQuantidadeMoedas()
    {
        return $this->quantidadeMoedas;
    }

    public function getNumAvisoDepbito()
    {
        return $this->numAvisoDepbito;
    }

    public function setQuantidadeRegistros($quantidadeRegistros)
    {
        $this->quantidadeRegistros = $quantidadeRegistros;
        return $this;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function setQuantidadeMoedas($quantidadeMoedas)
    {
        $this->quantidadeMoedas = $quantidadeMoedas;
        return $this;
    }

    public function setNumAvisoDepbito($numAvisoDepbito)
    {
        $this->numAvisoDepbito = $numAvisoDepbito;
        return $this;
    }
}