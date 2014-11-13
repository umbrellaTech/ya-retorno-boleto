<?php

namespace Umbrella\Ya\RetornoBoleto\Model;

class Sacado extends Pessoa
{
    /**
     * @var Inscricao
     */
    protected $inscricao;

    /**
     * @var Ocorrencia
     */
    protected $ocorrencia;

    /**
     * @return mixed
     */
    public function getInscricao()
    {
        return $this->inscricao;
    }

    /**
     * @param Inscricao $inscricao
     * @return $this
     */
    public function setInscricao(Inscricao $inscricao)
    {
        $this->inscricao = $inscricao;
        return $this;
    }

    /**
     * @return Ocorrencia
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * @param Ocorrencia $ocorrencia
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
    }

}
