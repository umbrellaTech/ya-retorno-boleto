<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use Umbrella\Ya\RetornoBoleto\Cnab\CnabTrailerInterface;

class TrailerLote extends AbstractTrailer implements Cnab240Interface, CnabTrailerInterface
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

    /**
     * @param string $quantidadeRegistros
     */
    public function setQuantidadeRegistros($quantidadeRegistros)
    {
        $this->quantidadeRegistros = $quantidadeRegistros;
        return $this;
    }

    /**
     * @param string $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @param string $quantidadeMoedas
     */
    public function setQuantidadeMoedas($quantidadeMoedas)
    {
        $this->quantidadeMoedas = $quantidadeMoedas;
        return $this;
    }

    /**
     * @param string $numAvisoDepbito
     */
    public function setNumAvisoDepbito($numAvisoDepbito)
    {
        $this->numAvisoDepbito = $numAvisoDepbito;
        return $this;
    }
}
