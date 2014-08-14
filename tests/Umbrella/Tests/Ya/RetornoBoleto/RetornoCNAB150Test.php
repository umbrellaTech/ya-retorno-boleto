<?php

namespace Umbrella\Tests\Ya\RetornoBoleto;

use Umbrella\Ya\RetornoBoleto\ProcessFactory;
use Umbrella\Ya\RetornoBoleto\ProcessHandler;

class RetornoCNAB150Test extends AbstractCnabTestCase
{

    public function cnabProvider()
    {
        return array(
            array(__DIR__ . '/../../Resources/ret/150/RCB001458908201414507.ret'),
            array(__DIR__ . '/../../Resources/ret/150/RCB001457808201414115.ret'),
            array(__DIR__ . '/../../Resources/ret/150/RCB001456708201413431.ret'),
            array(__DIR__ . '/../../Resources/ret/150/RCB001454508201412843.ret')
        );
    }

    /**
     * @dataProvider cnabProvider
     */
    public function testCnab150($fileName)
    {
        $cnab = ProcessFactory::getRetorno($fileName);

        $processor = new ProcessHandler($cnab);
        $retorno = $processor->processar();

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Retorno", $retorno);

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Cnab\\Cnab150\\Header",
                                $retorno->getHeader());

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Cnab\\Cnab150\\Trailer",
                                $retorno->getTrailer());
    }
}