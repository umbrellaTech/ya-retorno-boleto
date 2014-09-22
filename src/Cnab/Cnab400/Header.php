<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400;

use Easy\Collections\ArrayList;
use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;

class Header extends AbstractCnab400 implements HeaderInterface
{
    protected $tipoOperacao;
    protected $idTipoOperacao;
    protected $idTipoServico;
    protected $tipoServico;
    protected $dataGravacao;
    protected $sequencialReg;

    /**
     *
     * @var VectorInterface
     */
    protected $complementos;

    /**
     *
     * @var Cedente
     */
    protected $cedente;

    public function __construct()
    {
        $this->complementos = new ArrayList();
        parent::__construct();
    }

    public function getTipoOperacao()
    {
        return $this->tipoOperacao;
    }

    public function getIdTipoOperacao()
    {
        return $this->idTipoOperacao;
    }

    public function getIdTipoServico()
    {
        return $this->idTipoServico;
    }

    public function getTipoServico()
    {
        return $this->tipoServico;
    }

    public function getDataGravacao()
    {
        return $this->dataGravacao;
    }

    public function getSequencialReg()
    {
        return $this->sequencialReg;
    }

    public function getCedente()
    {
        return $this->cedente;
    }

    public function setTipoOperacao($tipoOperacao)
    {
        $this->tipoOperacao = $tipoOperacao;
        return $this;
    }

    public function setIdTipoOperacao($idTipoOperacao)
    {
        $this->idTipoOperacao = $idTipoOperacao;
        return $this;
    }

    public function setIdTipoServico($idTipoServico)
    {
        $this->idTipoServico = $idTipoServico;
        return $this;
    }

    public function setTipoServico($tipoServico)
    {
        $this->tipoServico = $tipoServico;
        return $this;
    }

    public function setDataGravacao($dataGravacao)
    {
        $this->dataGravacao = $dataGravacao;
        return $this;
    }

    public function setSequencialReg($sequencialReg)
    {
        $this->sequencialReg = $sequencialReg;
        return $this;
    }

    public function setCedente(Cedente $cedente)
    {
        $this->cedente = $cedente;
        return $this;
    }

    public function getComplementos()
    {
        return $this->complementos;
    }

    public function setComplementos(VectorInterface $complementos)
    {
        $this->complementos = $complementos;
        return $this;
    }

    public function addComplemento($complemento)
    {
        $trim = trim($complemento);
        if (!empty($trim)) {
            $this->complementos->add($complemento);
        }
        return $this;
    }

    public function removeComplemento($complemento)
    {
        $this->complementos->remove($complemento);
        return $this;
    }
}
