<?php

namespace Umbrella\Tests\Ya\RetornoBoleto\SegmentosCNAB240;

use Umbrella\Tests\Ya\RetornoBoleto\RetornoCNAB240Test;
use Umbrella\Ya\RetornoBoleto\ProcessFactory;
use Umbrella\Ya\RetornoBoleto\ProcessHandler;

abstract class AbstractSegmentoTestCase extends RetornoCNAB240Test
{
    public function segmentoProvider($segmento)
    {
        $segmentos = array();
        foreach ($this->cnabProvider() as $fileName) {
            $cnab = ProcessFactory::getRetorno(current($fileName));

            $processor = new ProcessHandler($cnab);
            $retorno = $processor->processar();

            $lotes = $retorno->getLotes();
            foreach ($lotes->get(0)->getDetails() as $detail) {
                if ($detail->getSegmento() == $segmento) {
                    $segmentos[] = array($detail);
                }
            }
        }
        return $segmentos;
    }

    public function segmentoTProvider()
    {
        return $this->segmentoProvider('T');
    }

    public function segmentoUProvider()
    {
        return $this->segmentoProvider('U');
    }
}