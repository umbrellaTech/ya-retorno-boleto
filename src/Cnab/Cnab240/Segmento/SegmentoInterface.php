<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use Stringy\Stringy;

interface SegmentoInterface
{
    public function buildDetail(Stringy $linha);
}
