<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;

/**
 * Classe que representa um banco.
 */
class Banco
{
    protected $cod;
    protected $nome;
    protected $agencia;
    protected $dvAgencia;
    protected $conta;
    protected $dvConta;
    protected $dvAgenciaConta;

    /**
     * @var VectorInterface
     */
    protected $reservados;

    /**
     * Inicializa uma instância da classe Banco.
     */
    public function __construct()
    {
        $this->reservados = new ArrayList();
    }

    public function setReservados(VectorInterface $reservados)
    {
        $this->reservados = $reservados;
        return $this;
    }

    public function getReservados()
    {
        return $this->reservados;
    }

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

    /**
     * @param string $agencia
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    /**
     * @param string $dvAgencia
     */
    public function setDvAgencia($dvAgencia)
    {
        $this->dvAgencia = $dvAgencia;
        return $this;
    }

    /**
     * @param string $conta
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
        return $this;
    }

    /**
     * @param string $dvConta
     */
    public function setDvConta($dvConta)
    {
        $this->dvConta = $dvConta;
        return $this;
    }

    public function getDvAgenciaConta()
    {
        return $this->dvAgenciaConta;
    }

    /**
     * @param string $dvAgenciaConta
     */
    public function setDvAgenciaConta($dvAgenciaConta)
    {
        $this->dvAgenciaConta = $dvAgenciaConta;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @param string $cnab
     */
    public function addReservado($cnab)
    {
        $trim = trim($cnab);
        if (!empty($trim)) {
            $this->reservados->add($cnab);
        }
        return $this;
    }

    public function removeReservado($cnab)
    {
        $this->reservados->remove($cnab);
        return $this;
    }
}