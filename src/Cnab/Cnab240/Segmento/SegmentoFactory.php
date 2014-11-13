<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use Exception;
use InvalidArgumentException;
use League\Flysystem\FileNotFoundException;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab150\Processor\CNAB150Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Processor\CNAB240Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor\CNAB400Conv6Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor\CNAB400Conv7Processor;
use Umbrella\Ya\RetornoBoleto\Exception\DetailSectionNotFoundException;
use Umbrella\Ya\RetornoBoleto\Exception\HeaderSectionNotFoundException;
use Umbrella\Ya\RetornoBoleto\Exception\InvalidHeaderException;
use Umbrella\Ya\RetornoBoleto\Exception\ReturnFileNotSupportedException;

/**
 * Classe que identifica o tipo de arquivo de retorno sendo carregado e instancia a classe
 * específica para leitura do mesmo.
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class SegmentoFactory
{
    /**
     * @param $tipo O tipo do segmento para carregar os detalhes
     * @return SegmentoInterface
     */
    public function getDetail($tipo)
    {
        $reflection = new \ReflectionClass('\Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento\Segmento' . strtoupper($tipo));
        return $reflection->newInstanceArgs();
    }
}
