<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use Easy\Collections\ArrayList;
use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;

abstract class AbstractCnab240
{
    protected $registro;
    protected $lote;

    /**
     *
     * @var Cedente
     */
    protected $cedente;

    /**
     *
     * @var IVector
     */
    protected $cnabs;

    /**
     *
     * @var IVector
     */
    protected $ocorrencias;

    public function __construct()
    {
        $this->cnabs = new ArrayList();

        $this->ocorrencias = new ArrayList();
    }

    public function addCnab($cnab)
    {
        $trim = trim($cnab);
        if (!empty($trim)) {
            $this->cnabs->add($cnab);
        }
        return $this;
    }

    public function removeCnab($cnab)
    {
        $this->cnabs->remove($cnab);
        return $this;
    }

    public function getCnabs()
    {
        return $this->cnabs;
    }

    public function setCnabs(IVector $cnabs)
    {
        $this->cnabs = $cnabs;
        return $this;
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function getLote()
    {
        return $this->lote;
    }

    public function getCedente()
    {
        return $this->cedente;
    }

    public function setRegistro($registro)
    {
        $this->registro = $registro;
        return $this;
    }

    public function setLote($lote)
    {
        $this->lote = $lote;
        return $this;
    }

    public function setCedente(Cedente $cedente)
    {
        $this->cedente = $cedente;
        return $this;
    }

    public function getOcorrencias()
    {
        return $this->ocorrencias;
    }

    public function setOcorrencias(IVector $ocorrencias)
    {
        $this->ocorrencias = $ocorrencias;
        return $this;
    }

    public function addOcorrencia($ocorrencia)
    {
        $trim = trim($ocorrencia);
        if (!empty($trim)) {
            $this->cnabs->add($ocorrencia);
        }
        return $this;
    }

    public function removeOcorrencia($ocorrencia)
    {
        $this->cnabs->remove($ocorrencia);
        return $this;
    }
}