<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use DateTime;
use Exception;
use InvalidArgumentException;
use League\Flysystem\FileNotFoundException;
use Stringy\Stringy;
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
abstract class AbstractSegmento implements SegmentoInterface
{
    /**
     * Formata uma string, contendo uma data sem o separador, no formato DDMMAA.
     * @param string $date String contendo a data no formato DDMMAA.
     * @param string $format
     * @return DateTime
     */
    public function createDate($date, $format = "mdy")
    {
        if (empty($date)) {
            return "";
        }

        return DateTime::createFromFormat($format, $date);
    }

    /**
     * Formata uma string, contendo uma data sem o separador, no formato DDMMAA HHIISS.
     * @param string $dateTimeString String contendo a data no formato DDMMAA.
     * @return DateTime
     */
    public function createDateTime($dateTimeString, $format = "mdy His")
    {
        if (empty($dateTimeString)) {
            return "";
        }

        return DateTime::createFromFormat($format, $dateTimeString);
    }

    public function convertToFloat(Stringy $string)
    {
        return (float)$string->__toString();
    }

    public function convertToInt(Stringy $string)
    {
        return (int)$string->__toString();
    }
}
