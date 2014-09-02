ya-retorno-boleto
=================

[![Build Status](https://travis-ci.org/umbrellaTech/ya-retorno-boleto.svg?branch=master)](https://travis-ci.org/umbrellaTech/ya-retorno-boleto)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/umbrella/retorno-boleto/v/stable.png)](https://packagist.org/packages/umbrella/retorno-boleto)
[![Latest Unstable Version](https://poser.pugx.org/umbrella/retorno-boleto/v/unstable.png)](https://packagist.org/packages/umbrella/retorno-boleto)
[![Documentation Status](https://readthedocs.org/projects/ya-retorno-boleto/badge/?version=latest)](https://readthedocs.org/projects/ya-retorno-boleto/?badge=latest)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ef6e9331-a2ad-4a22-bc43-1dd7c28ae086/small.png)](https://insight.sensiolabs.com/projects/ef6e9331-a2ad-4a22-bc43-1dd7c28ae086)

O que é?
---
Biblioteca em PHP para leitura de arquivos de retorno de títulos de cobrança de bancos brasileiros.

Arquivos suportados:

| **Banco**           |  **CNAB**                | **Implementado**   | **Testado**   |
|---------------------|--------------------------|--------------------|---------------|
| **Banco do Brasil** | 150, 240,400             | Sim                | Sim           |
| **Bradesco**        | 400 - personalizado      | Não                | Não           |
| **Caixa Economica** | 150, 240                 | Sim                | Sim           |
| **HSBC**            | 150, 240,400             | Sim                | Sim           |
| **Itau**            | 150, 240,400             | Sim                | Sim           |
| **Santander**       | 150, 240,400             | Sim                | Sim           |

Instalação
----------

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Adicionando YA Retorno Boleto como dependencia
php composer.phar require umbrella/retorno-boleto:~1.2
``` 

Após a instalação, é necessário carregar o autoloader do composer:

```php
require 'vendor/autoload.php';
```

Uso
----------

Para lermos um arquivo de retorno, utilizamos uma factory que nos dirao tipo correto do arquivo e passaremos ele para um processador que irá lhe retornar o objeto do arquivo de retorno.

```php
use Umbrella\Ya\RetornoBoleto\ProcessFactory;
use Umbrella\Ya\RetornoBoleto\ProcessHandler;

// Utilizamos a factory para construir o objeto correto para um determinado arquivo de retorno
$cnab = ProcessFactory::getRetorno('arquivo-retorno.ret');

// Passamos o objeto contruido para o handler
$processor = new ProcessHandler($cnab);
  
// Processamos o arquivo. Isso retornará um objeto parseado com todas as propriedades do arquvio.
$retorno = $processor->processar();
```

Eventos
----------

O retorno-boleto tem suporte a eventos utilizando o componente [EventDispatcher](http://symfony.com/doc/current/components/event_dispatcher/introduction.html) do symfony.

```php
use Umbrella\Ya\RetornoBoleto\Event\OnDetailRegisterEvent;
use Umbrella\Ya\RetornoBoleto\ProcessFactory;
use Umbrella\Ya\RetornoBoleto\ProcessHandler;
use Umbrella\Ya\RetornoBoleto\RetornoEvents;

// Passamos o objeto contruido para o handler
$processor = new ProcessHandler($cnab);

$processor->getDispatcher()->addListener(RetornoEvents::ON_DETAIL_REGISTER,
                                         function(OnDetailRegisterEvent $event) use($self, &$count) {
    echo $event->getLineNumber() . PHP_EOL;
});
        
```

Atualmente temos os seguintes eventos:

| **Evento**             |  **Event Class**         | **Descrição**                            |
|------------------------|--------------------------|------------------------------------------|
| **ON_DETAIL_REGISTER** | OnDetailRegisterEvent    | Lançado sempre que um registro é iterado | 


Demo
----------

A aplicação de demonstração está no repositório [Ya Boleto Demo](https://github.com/umbrellaTech/ya-boleto-demo)

Documentação
----------

Mais informações podem ser encontradas na documentação on-line em http://ya-retorno-boleto.readthedocs.org/pt_BR/latest/.
