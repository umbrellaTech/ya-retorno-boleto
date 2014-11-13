<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Empresa;
use Umbrella\Ya\RetornoBoleto\Model\Sacado;

abstract class AbstractCnab implements ComposableInterface
{
    protected $registro;
    protected $lote;

    /**
     * @var Cedente
     */
    protected $cedente;

    /**
     * @var Sacado
     */
    protected $sacado;

    /**
     *
     * @var VectorInterface
     */
    protected $cnabs;

    /**
     *
     * @var VectorInterface
     */
    protected $ocorrencias;

    /**
     *
     * @var Empresa
     */
    protected $empresa;

    public function __construct()
    {
        $this->cnabs = new ArrayList();
        $this->ocorrencias = new ArrayList();
    }

    /**
     * @return Sacado
     */
    public function getSacado()
    {
        return $this->sacado;
    }

    /**
     * @param Sacado $sacado
     * @return $this
     */
    public function setSacado(Sacado $sacado)
    {
        $this->sacado = $sacado;
        return $this;
    }

    /**
     * @param string $cnab
     * @return $this
     */
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

    public function setCnabs(VectorInterface $cnabs)
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

    /**
     * @param string $registro
     * @return $this
     */
    public function setRegistro($registro)
    {
        $this->registro = $registro;
        return $this;
    }

    /**
     * @param string $lote
     * @return $this
     */
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

    public function setOcorrencias(VectorInterface $ocorrencias)
    {
        $this->ocorrencias = $ocorrencias;
        return $this;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function setEmpresa(Empresa $empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

    /**
     * @param string $ocorrencia
     * @return $this
     */
    public function addOcorrencia($ocorrencia)
    {
        $trim = trim($ocorrencia);
        if (!empty($trim)) {
            $this->ocorrencias->add($ocorrencia);
        }
        return $this;
    }

    public function removeOcorrencia($ocorrencia)
    {
        $this->ocorrencias->remove($ocorrencia);
        return $this;
    }
}
