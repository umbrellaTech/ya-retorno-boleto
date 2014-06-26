<?php

namespace Umbrella\Ya\RetornoBoleto;

use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\ICnab240;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Processor\CNAB240Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor\AbstractCNAB400Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\ICnab400;
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

    private function createLote(IRetorno $retorno)
    {
        $lote = new Lote(); //Lote padrão
        $retorno->addLote($lote);
        return $lote;
    }

    /**
     * Executa o processamento de todo o arquivo, linha a linha. 
     * @return IRetorno
     */
    public function processar()
    {
        $retorno = new Retorno();
        $lote = null;

        $linhas = file($this->retorno->getNomeArquivo(), FILE_IGNORE_NEW_LINES);
        foreach ($linhas as $numLn => $linha) {
            $composable = $this->retorno->processarLinha($numLn,
                                                         rtrim($linha, "\r\n"));

            if ($this->retorno->needToCreateLote()) {
                $lote = $this->createLote($retorno);
            }

            $this->retorno->processCnab($retorno, $composable, $lote);

            //Dispara o evento aoProcessarLinha, caso haja alguma função handler associada a ele
            $this->retorno->triggerAoProcessarLinha($this->retorno, $numLn,
                                                    $composable);
        }

        return $retorno;
    }
}