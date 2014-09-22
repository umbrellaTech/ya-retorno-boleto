<?php

namespace Umbrella\Ya\RetornoBoleto\Event;

use Symfony\Component\EventDispatcher\Event;
use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\ComposableInterface;

class OnDetailRegisterEvent extends Event
{
    /**
     * @var AbstractProcessor 
     */
    protected $processor;

    /**
     * @var int 
     */
    protected $lineNumber;

    /**
     * @var ComposableInterface 
     */
    protected $composable;

    public function __construct(AbstractProcessor $processor, $lineNumber, ComposableInterface $composable)
    {
        $this->processor = $processor;
        $this->lineNumber = $lineNumber;
        $this->composable = $composable;
    }

    /**
     * Retorna o processador.
     * @return AbstractProcessor
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * Retorna a linha do arquivo que está sendo iterada.
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * Retorna o elemento ComposableInterface parseado após o processamento da linha.
     * @return ComposableInterface
     */
    public function getComposable()
    {
        return $this->composable;
    }
}
