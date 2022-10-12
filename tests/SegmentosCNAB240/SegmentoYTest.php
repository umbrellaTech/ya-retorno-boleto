<?php

namespace Umbrella\Tests\Ya\RetornoBoleto\SegmentosCNAB240;

class SegmentoYTest extends AbstractSegmentoTestCase
{
    /**
     * @dataProvider segmentoYProvider
     * @param $fileName
     */
    public function testSegmentoValue($segmentoYDetail)
    {
        $this->assertEquals('Y', $segmentoYDetail->getSegmento());
        $this->assertEquals('3', $segmentoYDetail->getRegistro());
    }
}
