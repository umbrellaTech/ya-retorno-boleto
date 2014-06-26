<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400;

use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cobranca;

interface ITrailer extends ICnabTrailer, ICnab400
{

    public function getRetorno();

    public function getTipoRegistro();

    public function getSequencial();

    /**
     * @return Banco
     */
    public function getBanco();

    /**
     * @return Cobranca
     */
    public function getSimples();

    /**
     * @return Cobranca
     */
    public function getVinculada();

    /**
     * @return Cobranca
     */
    public function getCaucionada();

    /**
     * @return Cobranca
     */
    public function getVendor();

    /**
     * @return Cobranca
     */
    public function getDescontada();

    /**
     * @return Trailer
     */
    public function setRetorno($retorno);

    /**
     * @return Trailer
     */
    public function setTipoRegistro($tipoRegistro);

    /**
     * @return Trailer
     */
    public function setSequencial($sequencial);

    /**
     * @return Trailer
     */
    public function setBanco(Banco $banco);

    /**
     * @return Trailer
     */
    public function setSimples(Cobranca $simples);

    /**
     * @return Trailer
     */
    public function setVinculada(Cobranca $vinculada);

    /**
     * @return Trailer
     */
    public function setCaucionada(Cobranca $caucionada);

    /**
     * @return Trailer
     */
    public function setVendor(Cobranca $vendor);

    /**
     * @return Trailer
     */
    public function setDescontada(Cobranca $descontada);
}