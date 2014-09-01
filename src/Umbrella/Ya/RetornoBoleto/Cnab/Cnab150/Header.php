<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab150;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;

class Header extends AbstractCnab150 implements CnabHeaderInterface
{
    /**
     * @var DateTime
     */
    protected $dataGeracao;
    protected $sequencialRet;
    protected $convenio;
    protected $versaoLayout;
    protected $remessa;

    public function getDataGeracao()
    {
        return $this->dataGeracao;
    }

    public function getSequencialRet()
    {
        return $this->sequencialRet;
    }

    public function getConvenio()
    {
        return $this->convenio;
    }

    public function getVersaoLayout()
    {
        return $this->versaoLayout;
    }

    public function getRemessa()
    {
        return $this->remessa;
    }

    public function setDataGeracao(DateTime $dataGeracao)
    {
        $this->dataGeracao = $dataGeracao;
        return $this;
    }

    public function setSequencialRet($sequencialRet)
    {
        $this->sequencialRet = $sequencialRet;
        return $this;
    }

    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

    public function setVersaoLayout($versaoLayout)
    {
        $this->versaoLayout = $versaoLayout;
        return $this;
    }

    public function setRemessa($remessa)
    {
        $this->remessa = $remessa;
        return $this;
    }
}
