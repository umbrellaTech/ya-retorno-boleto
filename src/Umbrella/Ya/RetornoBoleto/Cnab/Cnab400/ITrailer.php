<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400;

use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cobranca;

interface ITrailer extends IComposable
{

    public function getRegistro();

    public function getRetorno();

    public function getTipoRegistro();

    public function getSequencial();

    public function getBanco();

    public function getSimples();

    public function getVinculada();

    public function getCaucionada();

    public function getVendor();

    public function getDescontada();

    public function setRegistro($registro);

    public function setRetorno($retorno);

    public function setTipoRegistro($tipoRegistro);

    public function setSequencial($sequencial);

    public function setBanco(Banco $banco);

    public function setSimples(Cobranca $simples);

    public function setVinculada(Cobranca $vinculada);

    public function setCaucionada(Cobranca $caucionada);

    public function setVendor(Cobranca $vendor);

    public function setDescontada(Cobranca $descontada);
}