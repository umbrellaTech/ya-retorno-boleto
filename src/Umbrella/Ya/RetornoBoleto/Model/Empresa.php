<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

use Easy\Collections\ArrayList;
use Easy\Collections\IVector;

class Empresa
{
    protected $tipoInscricao;
    protected $numInscricao;
    protected $nome;

    /**
     *
     * @var Endereco
     */
    protected $endereco;

    /**
     *
     * @var IVector
     */
    protected $usos;

    /**
     *
     * @var IVector
     */
    protected $reservados;

    public function __construct()
    {
        $this->reservados = new ArrayList();
    }

    public function getTipoInscricao()
    {
        return $this->tipoInscricao;
    }

    public function getNumInscricao()
    {
        return $this->numInscricao;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getUsos()
    {
        return $this->usos;
    }

    public function setTipoInscricao($tipoInscricao)
    {
        $this->tipoInscricao = $tipoInscricao;
        return $this;
    }

    public function setNumInscricao($numInscricao)
    {
        $this->numInscricao = $numInscricao;
        return $this;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setEndereco(Endereco $endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function setUsos(IVector $usos)
    {
        $this->usos = $usos;
        return $this;
    }

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

    public function getReservados()
    {
        return $this->reservados;
    }

    public function setReservados(IVector $reservados)
    {
        $this->reservados = $reservados;
        return $this;
    }
}