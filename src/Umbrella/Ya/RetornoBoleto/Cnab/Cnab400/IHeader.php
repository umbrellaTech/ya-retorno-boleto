<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;

interface IHeader extends ICnabHeader, ICnab400
{

    public function getTipoOperacao();

    public function getIdTipoOperacao();

    public function getIdTipoServico();

    public function getTipoServico();

    public function getDataGravacao();

    public function getSequencialReg();

    /**
     * @return Header
     */
    public function setTipoOperacao($tipoOperacao);

    /**
     * @return Header
     */
    public function setIdTipoOperacao($idTipoOperacao);

    /**
     * @return Header
     */
    public function setIdTipoServico($idTipoServico);

    /**
     * @return Header
     */
    public function setTipoServico($tipoServico);

    /**
     * @return Header
     */
    public function setDataGravacao($dataGravacao);

    /**
     * @return Header
     */
    public function setSequencialReg($sequencialReg);

    /**
     * @return IVector
     */
    public function getComplementos();

    /**
     * @return Header
     */
    public function setComplementos(IVector $complementos);

    /**
     * @return Header
     */
    public function addComplemento($complemento);

    /**
     * @return Header
     */
    public function removeComplemento($complemento);
}