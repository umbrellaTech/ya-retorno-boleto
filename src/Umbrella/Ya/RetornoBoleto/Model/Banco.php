<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

class Banco
{
    protected $cod;
    protected $agencia;
    protected $dvAgencia;
    protected $conta;
    protected $dvConta;

    public function getCod()
    {
        return $this->cod;
    }

    public function getAgencia()
    {
        return $this->agencia;
    }

    public function getDvAgencia()
    {
        return $this->dvAgencia;
    }

    public function getConta()
    {
        return $this->conta;
    }

    public function getDvConta()
    {
        return $this->dvConta;
    }

    public function setCod($cod)
    {
        $this->cod = $cod;
        return $this;
    }

    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    public function setDvAgencia($dvAgencia)
    {
        $this->dvAgencia = $dvAgencia;
        return $this;
    }

    public function setConta($conta)
    {
        $this->conta = $conta;
        return $this;
    }

    public function setDvConta($dvConta)
    {
        $this->dvConta = $dvConta;
        return $this;
    }
}