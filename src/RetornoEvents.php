<?php

namespace Umbrella\Ya\RetornoBoleto;

class RetornoEvents
{
    /**
     * The store.order event is thrown each time an order is created
     * in the system.
     *
     * The event listener receives an
     * Event\OnDetailRegisterEvent instance.
     *
     * @var string
     */
    const ON_DETAIL_REGISTER = 'on.detail.register';

}
