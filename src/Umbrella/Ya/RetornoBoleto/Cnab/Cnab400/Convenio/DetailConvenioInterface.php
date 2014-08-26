<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio;

use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\DetailInterface;

interface DetailConvenioInterface extends DetailInterface
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

    /**
     * @return VectorInterface
     */
    public function getUsoBanco();

    /**
     * @return DetailConvenio
     */
    public function setConvenio($convenio);

    /**
     * @return DetailConvenio
     */
    public function setControle($controle);

    /**
     * @return DetailConvenio
     */
    public function setNossoNumero($nossoNumero);

    /**
     * @return DetailConvenio
     */
    public function setDvNossoNumero($dvNossoNumero);

    /**
     * @return DetailConvenio
     */
    public function setTipoCobranca($tipoCobranca);

    /**
     * @return DetailConvenio
     */
    public function setTipoCobrancaCmd72($tipoCobrancaCmd72);

    /**
     * @return DetailConvenio
     */
    public function setDiasCalculo($diasCalculo);

    /**
     * @return DetailConvenio
     */
    public function setNatureza($natureza);

    /**
     * @return DetailConvenio
     */
    public function setVariacaoCarteira($variacaoCarteira);

    /**
     * @return DetailConvenio
     */
    public function setContaCaucao($contaCaucao);

    /**
     * @return DetailConvenio
     */
    public function setConfirmacao($confirmacao);

    /**
     * @return DetailConvenio
     */
    public function setUsoBanco(VectorInterface $usoBanco);

    /**
     * @return DetailConvenio
     */
    public function addUsoBanco($usoBanco);

    /**
     * @return DetailConvenio
     */
    public function removeUsoBanco($usoBanco);

    public function getPrefixoTitulo();

    /**
     * @return DetailConvenio
     */
    public function setPrefixoTitulo($prefixoTitulo);
}