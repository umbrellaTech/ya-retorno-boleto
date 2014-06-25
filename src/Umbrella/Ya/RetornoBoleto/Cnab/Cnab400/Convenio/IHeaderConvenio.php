<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio;

use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\IHeader;

interface IHeaderConvenio extends IHeader
{

    public function getConvenio();

    public function getSequencialRet();

    public function setConvenio($convenio);

    public function setSequencialRet($sequencialRet);
}