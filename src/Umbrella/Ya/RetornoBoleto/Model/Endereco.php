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

    public function setLogradourdo($logradourdo)
    {
        $this->logradourdo = $logradourdo;
        return $this;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    public function setComplementoCep($complementoCep)
    {
        $this->complementoCep = $complementoCep;
        return $this;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }

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