<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

class Cedente
{
    protected $nome;

    /**
     *
     * @var Banco
     */
    protected $banco;

    public function getNome()
    {
        return $this->nome;
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setBanco(Banco $banco)
    {
        $this->banco = $banco;
        return $this;
    }
}