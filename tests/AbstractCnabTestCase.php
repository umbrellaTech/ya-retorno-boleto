<?php

namespace Umbrella\Tests\Ya\RetornoBoleto;

use PHPUnit_Framework_TestCase;
use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;

abstract class AbstractCnabTestCase extends PHPUnit_Framework_TestCase
{

    public function linhaProcessada(AbstractProcessor $self, $numLn,
                                    IComposable $composable)
    {
        if ($composable) {
            if ($composable->getRegistro() == $self::DETALHE) {
                printf("%08d: ", $numLn);
                echo get_class($self) . ": Nosso N&uacute;mero <b>" . $composable->getNossoNumero() . "</b> " .
                "Data <b>" . $composable->getDataOcorrencia() . "</b> " .
                "Valor <b>" . $composable->getValor() . "</b><br/>\n";
            }
        } else {
            echo "Tipo da linha n&atilde;o identificado<br/>\n";
        }
    }
}