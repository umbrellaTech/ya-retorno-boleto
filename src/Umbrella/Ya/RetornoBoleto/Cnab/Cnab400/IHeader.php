<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;

interface IHeader extends ICnabHeader, ICnab400
{

    public function getTipoOperacao();

    public function getIdTipoOperacao();

    public function getIdTipoServico();

    public function getTipoServico();

    public function getDataGravacao();

    public function getSequencialReg();

    public function setTipoOperacao($tipoOperacao);

    public function setIdTipoOperacao($idTipoOperacao);

    public function setIdTipoServico($idTipoServico);

    public function setTipoServico($tipoServico);

    public function setDataGravacao($dataGravacao);

    public function setSequencialReg($sequencialReg);

    public function getComplementos();

    public function setComplementos(IVector $complementos);

    public function addComplemento($complemento);

    public function removeComplemento($complemento);
}