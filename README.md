ya-retorno-boleto
=================

[![Build Status](https://travis-ci.org/umbrellaTech/ya-retorno-boleto.svg?branch=master)](https://travis-ci.org/umbrellaTech/ya-retorno-boleto)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/umbrellaTech/ya-retorno-boleto/?branch=master)

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
| **Santander**       | 150, 240,400             | Sim                | Sim           |-

Instalação
----------

```shell
  require: { "umbrella/retorno-boleto": "~1.2" }
  
  $ composer install
``` 

Uso
----------

Para lermos um arquivo de retorno, utilizamos uma factory que nos dirao tipo correto do arquivo e passaremos ele para um processador que irá lhe retornar o objeto do arquivo de retorno.

```php
  // Utilizamos a factory para construir o objeto correto para um determinado arquivo de retorno
  $cnab = ProcessFactory::getRetorno('arquivo-retorno.ret');

  // Passamos o objeto contruido para o handler
  $processor = new ProcessHandler($cnab);
  
  // Processamos o arquivo. Isso retornará um objeto parseado com todas as propriedades do arquvio.
  $retorno = $processor->processar();
```

API
----------

Em breve.
