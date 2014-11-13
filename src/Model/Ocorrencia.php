<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;

/**
 * Classe que representa um banco.
 */
class Ocorrencia
{
    /**
     * @var int
     */
    protected $cod;

    /**
     * @var \DateTime
     */
    protected $data;

    /**
     * @var float
     */
    protected $valor;

    /**
     * @var string
     */
    protected $complemento;

    /**
     * @return int
     */
    public function getCod()
    {
        return $this->cod;
    }

    /**
     * @param int $cod
     * @return $this
     */
    public function setCod($cod)
    {
        $this->cod = $cod;
        return $this;
    }

    /**
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * @param string $complemento
     * @return $this
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \DateTime $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     * @return $this
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

}
