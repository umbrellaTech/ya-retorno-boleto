<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\ArrayList;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor\AbstractCNAB400Processor;

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
     * @property AbstractProcessor $retorno 
     * Atributo que deve ser um objeto de uma classe que estenda a classe AbstractRetorno 
     */
    protected $retorno;

    /**
     * Construtor da classe
     * @param AbstractProcessor $retorno Objeto de uma sub-classe de AbstractRetorno,
     * que implementa a leitura de arquivo de retorno para uma determinada carteira
     * de um banco específico.
     */
    public function __construct(AbstractProcessor $retorno)
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
            $consumable = $this->retorno->processarLinha($numLn,
                                                         rtrim($linha, "\r\n"));

            if ($consumable->getRegistro() == AbstractCNAB400Processor::HEADER_ARQUIVO) {
                $retorno->setHeader($consumable);
            } elseif ($consumable->getRegistro() == AbstractCNAB400Processor::TRAILER_ARQUIVO) {
                $retorno->setTrailer($consumable);
            } else {
                $details->add($consumable);
            }

            //Dispara o evento aoProcessarLinha, caso haja alguma função handler associada a ele
            $this->retorno->triggerAoProcessarLinha($this->retorno, $numLn,
                                                    $consumable);
        }

        $retorno->setDetails($details);
        return $retorno;
    }
}