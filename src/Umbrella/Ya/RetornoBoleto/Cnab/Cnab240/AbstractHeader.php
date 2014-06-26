<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Empresa;

abstract class AbstractHeader extends AbstractCnab240
{
    protected $convenio;
    protected $versaoLayout;

    /**
     *
     * @var Cedente
     */
    protected $empresa;

    public function getConvenio()
    {
        return $this->convenio;
    }

    public function getVersaoLayout()
    {
        return $this->versaoLayout;
    }

    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param string $convenio
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

    /**
     * @param string $versaoLayout
     */
    public function setVersaoLayout($versaoLayout)
    {
        $this->versaoLayout = $versaoLayout;
        return $this;
    }

    public function setEmpresa(Empresa $empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }
}