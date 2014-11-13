<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

class Inscricao
{
    /**
     * @var int
     */
    protected $numero;

    /**
     * @var string
     */
    protected $tipo;

    public function __construct($numero, $tipo)
    {
        $this->numero = $numero;
        $this->tipo = $tipo;
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     * @return $this
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     * @return $this
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

}
