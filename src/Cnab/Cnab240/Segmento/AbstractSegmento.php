<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use DateTime;
use Stringy\Stringy;

/**
 * Classe que identifica o tipo de arquivo de retorno sendo carregado e instancia a classe
 * específica para leitura do mesmo.
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
abstract class AbstractSegmento implements SegmentoInterface
{

    const DECIMAL_POINTS = 2;

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

    /**
     * Converte uma stringy para um float, de acordo com a quantidade de casas decimais passadas
     * @param Stringy $string
     * @param int $decimalPoints
     * @return float
     */
    public function convertToFloat(Stringy $string, $decimalPoints = self::DECIMAL_POINTS)
    {
        if (!is_int($decimalPoints)) {
            $decimalPoints = self::DECIMAL_POINTS;
        }
        return (float) preg_replace('#(\d*)(\d{' . $decimalPoints . '})$#', '$1.$2', $string->__toString());
    }

    public function convertToInt(Stringy $string)
    {
        return (int)$string->__toString();
    }
}
