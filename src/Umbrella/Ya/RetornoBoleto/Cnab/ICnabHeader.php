<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab;

use Umbrella\Ya\RetornoBoleto\Model\Cedente;

interface ICnabHeader extends IComposable
{

    public function getCedente();

    public function setCedente(Cedente $cedente);
}