<?php

namespace Umbrella\Ya\RetornoBoleto;

use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\ICnab240;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Processor\CNAB240Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor\AbstractCNAB400Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;

/**
 * Classe que implementa o design pattern Strategy,
 * para leitura de arquivos de retorno de cobranças dos bancos brasileiros,
 * vincular uma classe para processamento de uma carteira específica
 * de arquivo de retorno, e criando uma interface única
 * para a execução do processamento do arquivo.<br/>
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class ProcessHandler
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
        $lote = new Lote(); //Lote padrão

        $linhas = file($this->retorno->getNomeArquivo(), FILE_IGNORE_NEW_LINES);
        foreach ($linhas as $numLn => $linha) {
            $composable = $this->retorno->processarLinha($numLn,
                                                         rtrim($linha, "\r\n"));

            if ($composable->getRegistro() == CNAB240Processor::HEADER_LOTE) {
                $lote = new Lote();
            }

            if ($composable instanceof ICnab240) {
                $this->processCnab240($retorno, $lote, $composable);
            } else {
                $this->processCnab400($retorno, $lote, $composable);
            }

            //Dispara o evento aoProcessarLinha, caso haja alguma função handler associada a ele
            $this->retorno->triggerAoProcessarLinha($this->retorno, $numLn,
                                                    $composable);
        }

        return $retorno;
    }

    public function processCnab240(IRetorno $retorno, ILote $lote,
                                   IComposable $composable)
    {
        if ($composable->getRegistro() == CNAB240Processor::HEADER_ARQUIVO) {
            $retorno->setHeader($composable);
        } elseif ($composable->getRegistro() == CNAB240Processor::TRAILER_ARQUIVO) {
            $retorno->setTrailer($composable);
        } elseif ($composable->getRegistro() == CNAB240Processor::HEADER_LOTE) {
            $lote->setHeader($composable);
        } elseif ($composable->getRegistro() == CNAB240Processor::TRAILER_LOTE) {
            $lote->setTrailer($composable);
        } else {
            $lote->addDetail($composable);
        }
    }

    public function processCnab400(IRetorno $retorno, ILote $lote,
                                   IComposable $composable)
    {
        if ($composable->getRegistro() == AbstractCNAB400Processor::HEADER_ARQUIVO) {
            $retorno->setHeader($composable);
        } elseif ($composable->getRegistro() == AbstractCNAB400Processor::TRAILER_ARQUIVO) {
            $retorno->setTrailer($composable);
        } else {
            $lote->addDetail($composable);
        }
    }
}