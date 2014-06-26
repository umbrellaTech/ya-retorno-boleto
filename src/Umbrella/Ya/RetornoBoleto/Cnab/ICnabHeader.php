<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab;

use Umbrella\Ya\RetornoBoleto\Model\Cedente;

interface ICnabHeader extends IComposable
{

    /**
     * @return Cedente
     */
    public function getCedente();

    public function setCedente(Cedente $cedente);
}