<?php

namespace Umbrella\Ya\RetornoBoleto;

/**
 * Classe que identifica o tipo de arquivo de retorno sendo carregado e instancia a classe
 * específica para leitura do mesmo.
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class RetornoFactory
{

    /**
     * Instancia um objeto de uma das sub-classes de AbstractRetorno,
     * com base no tipo do arquivo de retorno indicado por $fileName
     * @param string fileName Nome do arquivo de retorno a ser identificado
     * para poder instancia a classe específica para leitura do mesmo.
     * @param string $aoProcessarLinhaFunctionName @see RetornoBase
     * @return AbstractRetorno Retorna um objeto de uma das sub-classes de RetornoBase.
     */
    public static function getRetorno($fileName,
                                      $aoProcessarLinhaFunctionName = null)
    {
        if (!$fileName) {
            throw new \InvalidArgumentException("Informe o nome do arquivo de retorno.");
        }

        $arq = fopen($fileName, "r");
        if ($arq) {
            //Lê o header do arquivo
            $linha = fgets($arq, 500);
            if ($linha) {
                //echo "<h1>Arquivo: $fileName. Linha: $linha</h1>";
                $len = strlen($linha);
                if ($len >= 240 and $len <= 242) {
                    return new RetornoCNAB240($fileName,
                                              $aoProcessarLinhaFunctionName);
                } else if ($len >= 400 and $len <= 402) {
                    if (strstr($linha, "BRADESCO")) {
                        return new RetornoCNAB400Bradesco($fileName,
                                                          $aoProcessarLinhaFunctionName);
                    }

                    //Lê o primeiro registro detalhe
                    $linha = fgets($arq, 500);
                    if ($linha) {
                        switch ($linha[0]) {
                            case RetornoCNAB400Conv6::DETALHE:
                                return new RetornoCNAB400Conv6($fileName,
                                                               $aoProcessarLinhaFunctionName);
                                break;
                            case RetornoCNAB400Conv7::DETALHE:
                                return new RetornoCNAB400Conv7($fileName,
                                                               $aoProcessarLinhaFunctionName);
                                break;
                            default:
                                throw new \Exception("Tipo de registro detalhe desconhecido: " . $linha[0]);
                                break;
                        }
                    } else {
                        throw new \Exception("Tipo de arquivo de retorno não identificado. Não foi possível ler um registro detalhe.");
                    }
                } else {
                    throw new \Exception("Tipo de arquivo de retorno não identificado. Total de colunas do header: $len");
                }
            } else {
                fclose($arq);
                throw new \Exception("Tipo de arquivo de retorno não identificado. Não foi possível ler o header do arquivo.");
            }
        } else {
            throw new \League\Flysystem\FileNotFoundException("Não foi possível abrir o arquivo \"$fileName\".");
        }
    }
}