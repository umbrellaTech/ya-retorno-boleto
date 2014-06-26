<?php

namespace Umbrella\Tests\Ya\RetornoBoleto;

use PHPUnit_Framework_TestCase;
use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;
use Umbrella\Ya\RetornoBoleto\ProcessFactory;
use Umbrella\Ya\RetornoBoleto\ProcessHandler;

class RetornoCNAB240Test extends PHPUnit_Framework_TestCase
{

    public function linhaProcessada(AbstractProcessor $self, $numLn,
                                    IComposable $vlinha)
    {
        if ($vlinha) {
            if ($vlinha->getRegistro() == $self::DETALHE) {
                printf("%08d: ", $numLn);
                echo get_class($self) . ": Nosso N&uacute;mero <b>" . $vlinha->getNossoNumero() . "</b> " .
                "Data <b>" . $vlinha->getDataOcorrencia() . "</b> " .
                "Valor <b>" . $vlinha->getValor() . "</b><br/>\n";
            }
        } else {
            echo "Tipo da linha n&atilde;o identificado<br/>\n";
        }
    }

    public function cnabProvider()
    {
        return array(
            array(__DIR__ . '/../../Resources/ret/retorno_cnab240.ret')
        );
    }

    /**
     * @dataProvider cnabProvider
     */
    public function testCnab240($fileName)
    {
        $cnab = ProcessFactory::getRetorno($fileName);

        $retorno = new ProcessHandler($cnab);
        $retornoObj = $retorno->processar();

        $retornoObj->getHeader();
        $retornoObj->getTrailer();
        foreach ($retornoObj->getLotes() as $lote) {
            $lote->getHeader();
            $lote->getTrailer();
            foreach ($lote->getDetails() as $details) {
                
            }
        }
    }
}