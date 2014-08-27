<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;

class Header extends AbstractHeader implements Cnab240Interface, CnabHeaderInterface
{
    protected $codArquivo;
    protected $densidade;

    /**
     *
     * @var DateTime
     */
    protected $dataGeracao;
    protected $sequencialRet;

    public function getCodArquivo()
    {
        return $this->codArquivo;
    }

    public function getDensidade()
    {
        return $this->densidade;
    }

    public function getDataGeracao()
    {
        return $this->dataGeracao;
    }

    public function getSequencialRet()
    {
        return $this->sequencialRet;
    }

    /**
     * @param string $codArquivo
     */
    public function setCodArquivo($codArquivo)
    {
        $this->codArquivo = $codArquivo;
        return $this;
    }

    public function setDensidade($densidade)
    {
        $this->densidade = $densidade;
        return $this;
    }

    public function setDataGeracao($dataGeracao)
    {
        $this->dataGeracao = $dataGeracao;
        return $this;
    }

    /**
     * @param string $sequencialRet
     */
    public function setSequencialRet($sequencialRet)
    {
        $this->sequencialRet = $sequencialRet;
        return $this;
    }
}
