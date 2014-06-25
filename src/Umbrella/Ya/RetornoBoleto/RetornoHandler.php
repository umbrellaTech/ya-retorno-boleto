<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;

/**
 * Classe que implementa o design pattern Strategy,
 * para leitura de arquivos de retorno de cobranças dos bancos brasileiros,
 * vincular uma classe para processamento de uma carteira específica
 * de arquivo de retorno, e criando uma interface única
 * para a execução do processamento do arquivo.<br/>
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class RetornoHandler
{
    /**
     * @property AbstractRetorno $retorno 
     * Atributo que deve ser um objeto de uma classe que estenda a classe AbstractRetorno 
     */
    protected $retorno;

    /**
     * Construtor da classe
     * @param AbstractRetorno $retorno Objeto de uma sub-classe de AbstractRetorno,
     * que implementa a leitura de arquivo de retorno para uma determinada carteira
     * de um banco específico.
     */
    public function __construct(AbstractRetorno $retorno)
    {
        $this->retorno = $retorno;
    }

    /**
     * Executa o processamento de todo o arquivo, linha a linha. 
     * @return IRetorno
     */
    public function processar()
    {
        $retorno = new Retorno();

        $details = new ArrayList();

        $linhas = file($this->retorno->getNomeArquivo(), FILE_IGNORE_NEW_LINES);
        foreach ($linhas as $numLn => $linha) {
            $vlinha = $this->retorno->processarLinha($numLn,
                                                     rtrim($linha, "\r\n"));

            if ($vlinha->getRegistro() == AbstractRetornoCNAB400::HEADER_ARQUIVO) {
                $retorno->setHeader($vlinha);
            } elseif ($vlinha->getRegistro() == AbstractRetornoCNAB400::TRAILER_ARQUIVO) {
                $retorno->setTrailer($vlinha);
            } else {
                $details->add($vlinha);
            }

            //Dispara o evento aoProcessarLinha, caso haja alguma função handler associada a ele
            $this->retorno->triggerAoProcessarLinha($this->retorno, $numLn,
                                                    $vlinha);
        }

        $retorno->setDetails($details);
        return $retorno;
    }
}