=================
Bem vindo ao YA Retorno Boleto
=================

O que é?
~~~~~~~~~~~~~~~

Yet Another Retorno Boleto é uma biblioteca em PHP para leitura de arquivos de retorno de títulos de cobrança 
de bancos brasileiros.

Principais funcionalidades
--------------------

- Parser de arquivos de retorno da FEBRABAN em uma unica interface.
- Fácil extensão para funcionar com qualquer arquivo de retorno não suportado.

.. code-block:: php

    use Umbrella\Ya\RetornoBoleto\ProcessFactory;
    use Umbrella\Ya\RetornoBoleto\ProcessHandler;

    // Utilizamos a factory para construir o objeto correto para um determinado arquivo de retorno
    $cnab = ProcessFactory::getRetorno('arquivo-retorno.ret');

    // Passamos o objeto contruido para o handler
    $processor = new ProcessHandler($cnab);

    // Processamos o arquivo. Isso retornará um objeto parseado com todas as propriedades do arquvio.
    $retorno = $processor->processar();

License
-------

Licensed using the `MIT license <http://opensource.org/licenses/MIT>`_.

    The MIT License (MIT)

    Copyright (c) 2014 Umbrella Tech

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
