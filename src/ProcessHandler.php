<?php

namespace Umbrella\Ya\RetornoBoleto;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Umbrella\Ya\RetornoBoleto\Event\OnDetailRegisterEvent;

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
     * @property AbstractProcessor $processor 
     * Atributo que deve ser um objeto de uma classe que estenda a classe AbstractRetorno 
     */
    protected $processor;
    protected $dispatcher;

    /**
     * Construtor da classe
     * @param AbstractProcessor $retorno Objeto de uma sub-classe de AbstractRetorno,
     * que implementa a leitura de arquivo de retorno para uma determinada carteira
     * de um banco específico.
     */
    public function __construct(AbstractProcessor $retorno)
    {
        $this->processor = $retorno;
        $this->dispatcher = new EventDispatcher();
    }

    /**
     * Recupera o dispatcher para o EventDispatcher.
     * @return EventDispatcherInterface
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    private function createLote(RetornoInterface $retorno)
    {
        $lote = new Lote(); //Lote padrão
        $retorno->addLote($lote);
        return $lote;
    }

    /**
     * Executa o processamento de todo o arquivo, linha a linha. 
     * @return RetornoInterface
     */
    public function processar()
    {
        $retorno = new Retorno();
        $lote = null;

        $lines = file($this->processor->getNomeArquivo(), FILE_IGNORE_NEW_LINES);
        foreach ($lines as $lineNumber => $lineContent) {
            $composable = $this->processor->processarLinha($lineNumber, rtrim($lineContent, "\r\n"));

            if ($this->processor->needToCreateLote()) {
                $lote = $this->createLote($retorno);
            }

            $this->processor->processCnab($retorno, $composable, $lote);

            $event = new OnDetailRegisterEvent($this->processor, $lineNumber, $composable);
            $this->dispatcher->dispatch(RetornoEvents::ON_DETAIL_REGISTER, $event);
        }

        return $retorno;
    }
}
