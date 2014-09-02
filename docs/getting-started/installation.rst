============
Instalação
============

Requisitos
------------

#. PHP 5.3.3+ compilado com a extensão cURL
#. A versão atual do cURL 7.16.2+ compilado com OpenSSL e zlib

Instalando YA Retorno Boleto
-----------------

Composer
~~~~~~~~

A maneira recomendada de instalar YA Retorno Boleto é com o 'Composer <http://getcomposer.org> `_. Composer é uma 
ferramenta de gerenciamento de dependência para PHP que lhe permite declarar as dependências que o seu projeto precisa 
e instala-los em seu projeto.

.. code-block:: bash

    # Install Composer
    curl -sS https://getcomposer.org/installer | php

    # Adicionando YA Retorno Boleto como dependencia
    php composer.phar require umbrella/retorno-boleto:~1.2

Após a instalação, é necessário carregar o autoloader do composer:

.. code-block:: php

    require 'vendor/autoload.php';

Você pode encontrar mais informações sobre como instalar o Composer, configurar o carregamento automático, 
e outras boas práticas para a definição dependências em `getcomposer.org <http://getcomposer.org>` _.

Mantendo-se atualizado
^^^^^^^^^^^^^

Durante o desenvolvimento, você pode manter-se com as últimas alterações do branch master, definindo a versão 
do YA Retorno Boleto para `` dev-master``.

.. code-block:: js

   {
      "require": {
         "umbrella/retorno-boleto": "dev-master"
      }
   }