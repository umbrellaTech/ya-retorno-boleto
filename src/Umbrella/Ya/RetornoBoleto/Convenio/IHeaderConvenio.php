<?php

namespace Umbrella\Ya\RetornoBoleto\Convenio;

use Umbrella\Ya\RetornoBoleto\IHeader;

interface IHeaderConvenio extends IHeader
{

    public function getConvenio();

    public function getSequencialRet();

    public function setConvenio($convenio);

    public function setSequencialRet($sequencialRet);
}