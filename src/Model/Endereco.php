<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

class Endereco
{
    protected $logradourdo;
    protected $numero;
    protected $complemento;
    protected $cep;
    protected $complementoCep;
    protected $cidade;
    protected $estado;

    public function getLogradourdo()
    {
        return $this->logradourdo;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function getComplementoCep()
    {
        return $this->complementoCep;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $logradourdo
     */
    public function setLogradourdo($logradourdo)
    {
        $this->logradourdo = $logradourdo;
        return $this;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @param string $complemento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * @param string $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * @param string $complementoCep
     */
    public function setComplementoCep($complementoCep)
    {
        $this->complementoCep = $complementoCep;
        return $this;
    }

    /**
     * @param string $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    public function getCepCompleto()
    {
        return $this->cep . $this->complementoCep;
    }
}
