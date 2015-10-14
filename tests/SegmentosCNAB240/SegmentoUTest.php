<?php

namespace Umbrella\Tests\Ya\RetornoBoleto\SegmentosCNAB240;

class SegmentoUTest extends AbstractSegmentoTestCase
{
    /**
     * @dataProvider segmentoUProvider
     * @param $fileName
     */
    public function testMonetaryValues($segmentoUDetail)
    {
        $this->assertEquals('U', $segmentoUDetail->getSegmento());
        $this->assertTrue(is_double($segmentoUDetail->getDadosTitulo()->getValorPago()));
    }
}