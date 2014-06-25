<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\IDetail;

interface IDetailConvenio extends IDetail
{

    public function getConvenio();

    public function getControle();

    public function getNossoNumero();

    public function getDvNossoNumero();

    public function getTipoCobranca();

    public function getTipoCobrancaCmd72();

    public function getDiasCalculo();

    public function getNatureza();

    public function getVariacaoCarteira();

    public function getContaCaucao();

    public function getConfirmacao();

    public function getUsoBanco();

    public function setConvenio($convenio);

    public function setControle($controle);

    public function setNossoNumero($nossoNumero);

    public function setDvNossoNumero($dvNossoNumero);

    public function setTipoCobranca($tipoCobranca);

    public function setTipoCobrancaCmd72($tipoCobrancaCmd72);

    public function setDiasCalculo($diasCalculo);

    public function setNatureza($natureza);

    public function setVariacaoCarteira($variacaoCarteira);

    public function setContaCaucao($contaCaucao);

    public function setConfirmacao($confirmacao);

    public function setUsoBanco(IVector $usoBanco);

    public function addUsoBanco($usoBanco);

    public function removeUsoBanco($usoBanco);

    public function getPrefixoTitulo();

    public function setPrefixoTitulo($prefixoTitulo);
}