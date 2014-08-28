<?php

namespace Umbrella\Ya\RetornoBoleto;

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
class ProcessFactory
{

    /**
     * Instancia um objeto de uma das sub-classes de AbstractRetorno,
     * com base no tipo do arquivo de retorno indicado por $fileName
     * @param string fileName Nome do arquivo de retorno a ser identificado
     * para poder instancia a classe específica para leitura do mesmo.
     * @param string $aoProcessarLinhaFunctionName 
     * @return AbstractProcessor Retorna um objeto de uma das sub-classes de AbstractProcessor.
     */
    public static function getRetorno($fileName, $aoProcessarLinhaFunctionName = null)
    {
        if (!$fileName) {
            throw new InvalidArgumentException("Informe o nome do arquivo de retorno.");
        }

        $arq = fopen($fileName, "r");
        if (!$arq) {
            throw new FileNotFoundException("Não foi possível abrir o arquivo \"$fileName\".");
        }

        //Lê o header do arquivo
        $linha = fgets($arq, 500);
        if (!$linha) {
            fclose($arq);
            throw new HeaderSectionNotFoundException("Tipo de arquivo de retorno não identificado. Não foi possível ler o header do arquivo.");
        }

        $len = strlen($linha);
        if ($len >= 150 && $len <= 152) {
            return new CNAB150Processor($fileName, $aoProcessarLinhaFunctionName);
        } elseif ($len >= 240 && $len <= 242) {
            return new CNAB240Processor($fileName, $aoProcessarLinhaFunctionName);
        } elseif ($len >= 400 && $len <= 402) {
            if (strstr($linha, "BRADESCO")) {
                throw new ReturnFileNotSupportedException('Arquivo de retorno Bradesco não suportado.');
            }

            //Lê o primeiro registro detalhe
            $linha = fgets($arq, 500);
            if (!$linha) {
                throw new DetailSectionNotFoundException("Tipo de arquivo de retorno não identificado. Não foi possível ler um registro detalhe.");
            }
            switch ($linha[0]) {
                case CNAB400Conv6Processor::DETALHE:
                    return new CNAB400Conv6Processor($fileName, $aoProcessarLinhaFunctionName);
                case CNAB400Conv7Processor::DETALHE:
                    return new CNAB400Conv7Processor($fileName, $aoProcessarLinhaFunctionName);
                default:
                    throw new Exception("Tipo de registro detalhe desconhecido: " . $linha[0]);
            }
        } else {
            throw new InvalidHeaderException("Tipo de arquivo de retorno não identificado. Total de colunas do header: $len");
        }
    }
}
