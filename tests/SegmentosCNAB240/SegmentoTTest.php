<?php

namespace Umbrella\Tests\Ya\RetornoBoleto\SegmentosCNAB240;

class SegmentoTTest extends AbstractSegmentoTestCase
{
    /**
     * @dataProvider segmentoTProvider
     * @param $fileName
     */
    public function testMonetaryValues($segmentoTDetail)
    {
        $this->assertEquals('T', $segmentoTDetail->getSegmento());
        $this->assertTrue(is_double($segmentoTDetail->getValorTarifa()));
    }
}