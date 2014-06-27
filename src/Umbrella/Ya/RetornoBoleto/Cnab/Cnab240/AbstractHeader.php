<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

abstract class AbstractHeader extends AbstractCnab240
{
    protected $convenio;
    protected $versaoLayout;

    public function getConvenio()
    {
        return $this->convenio;
    }

    public function getVersaoLayout()
    {
        return $this->versaoLayout;
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
}