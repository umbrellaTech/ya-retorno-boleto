<?php

namespace Umbrella\Tests\Ya\RetornoBoleto;

use PHPUnit_Framework_TestCase;
use Umbrella\Ya\RetornoBoleto\AbstractRetorno;
use Umbrella\Ya\RetornoBoleto\RetornoFactory;
use Umbrella\Ya\RetornoBoleto\RetornoHandler;

class RetornoCNAB400Test extends PHPUnit_Framework_TestCase
{

    public function linhaProcessada(AbstractRetorno $self, $numLn, $vlinha)
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

    public function conveio6Provider()
    {
        return array(
            array(__DIR__ . '/../../Resources/ret/retorno_cnab400conv6.ret')
        );
    }

    public function conveio7Provider()
    {
        return array(
            array(__DIR__ . '/../../Resources/ret/retorno_cnab400conv7.ret')
        );
    }

    /**
     * @dataProvider conveio6Provider
     */
    public function testConvenio6($fileName)
    {
        $cnab400 = RetornoFactory::getRetorno($fileName,
                                              array($this, "linhaProcessada"));

        $retorno = new RetornoHandler($cnab400);
        $retorno->processar();
    }

    /**
     * @dataProvider conveio7Provider
     */
    public function testConvenio7($fileName)
    {
        $cnab400 = RetornoFactory::getRetorno($fileName,
                                              array($this, "linhaProcessada"));

        $retorno = new RetornoHandler($cnab400);
        $retorno->processar();
    }
}