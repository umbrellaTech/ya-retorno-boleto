<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use DateTime;
use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabDetailInterface;

interface SegmentoInterface
{
    public function buildDetail(Stringy $linha);
}
