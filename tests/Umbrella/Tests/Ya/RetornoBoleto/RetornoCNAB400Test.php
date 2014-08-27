<?php

namespace Umbrella\Tests\Ya\RetornoBoleto;

use Umbrella\Ya\RetornoBoleto\ProcessFactory;
use Umbrella\Ya\RetornoBoleto\ProcessHandler;

class RetornoCNAB400Test extends AbstractCnabTestCase
{

    public function conveio6Provider()
    {
        return array(
            array(__DIR__ . '/../../Resources/ret/400/retorno_cnab400conv6.ret'),
            array(__DIR__ . '/../../Resources/ret/400/CBR64334531308201411115.ret')
        );
    }

    public function conveio7Provider()
    {
        return array(
            array(__DIR__ . '/../../Resources/ret/400/retorno_cnab400conv7.ret')
        );
    }

    /**
     * @dataProvider conveio6Provider
     */
    public function testConvenio6($fileName)
    {
        $cnab400 = ProcessFactory::getRetorno($fileName);

        $processor = new ProcessHandler($cnab400);
        $retorno = $processor->processar();

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Retorno", $retorno);

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Cnab\\Cnab400\\Convenio\\HeaderConvenioInterface",
                                $retorno->getHeader());
    }

    /**
     * @dataProvider conveio7Provider
     */
    public function testConvenio7($fileName)
    {
        $cnab400 = ProcessFactory::getRetorno($fileName);

        $processor = new ProcessHandler($cnab400);
        $retorno = $processor->processar();

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Retorno", $retorno);

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Cnab\\Cnab400\\HeaderInterface",
                                $retorno->getHeader());

        $this->assertInstanceOf("Umbrella\\Ya\\RetornoBoleto\\Cnab\\Cnab400\\TrailerInterface",
                                $retorno->getTrailer());
    }
}