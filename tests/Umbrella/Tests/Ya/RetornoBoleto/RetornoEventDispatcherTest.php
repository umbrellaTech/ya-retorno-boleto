<?php

namespace Umbrella\Tests\Ya\RetornoBoleto;

use Umbrella\Ya\RetornoBoleto\Event\OnDetailRegisterEvent;
use Umbrella\Ya\RetornoBoleto\ProcessFactory;
use Umbrella\Ya\RetornoBoleto\ProcessHandler;
use Umbrella\Ya\RetornoBoleto\RetornoEvents;

class RetornoEventDispatcherTest extends AbstractCnabTestCase
{

    public function cnabProvider()
    {
        return array(
            array(__DIR__ . '/../../Resources/ret/150/RCB001458908201414507.ret')
        );
    }

    /**
     * @dataProvider cnabProvider
     */
    public function testEvent($fileName)
    {
        $cnab400 = ProcessFactory::getRetorno($fileName);

        $processor = new ProcessHandler($cnab400);

        $self = $this;
        $count = 0;
        $processor->getDispatcher()->addListener(RetornoEvents::ON_DETAIL_REGISTER,
                                                 function(OnDetailRegisterEvent $event) use($self, &$count) {
            $self->assertEquals($event->getLineNumber(), $count);
            $count++;
        });

        $retorno = $processor->processar();
        $this->assertNotNull($retorno);
    }
}
