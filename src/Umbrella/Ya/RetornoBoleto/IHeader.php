<?php

namespace Umbrella\Ya\RetornoBoleto;

use Easy\Collections\IVector;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;

interface IHeader
{

    public function getRegistro();

    public function getTipoOperacao();

    public function getIdTipoOperacao();

    public function getIdTipoServico();

    public function getTipoServico();

    public function getDataGravacao();

    public function getSequencialReg();

    public function getCedente();

    public function setRegistro($registro);

    public function setTipoOperacao($tipoOperacao);

    public function setIdTipoOperacao($idTipoOperacao);

    public function setIdTipoServico($idTipoServico);

    public function setTipoServico($tipoServico);

    public function setDataGravacao($dataGravacao);

    public function setSequencialReg($sequencialReg);

    public function setCedente(Cedente $cedente);

    public function getComplementos();

    public function setComplementos(IVector $complementos);

    public function addComplemento($complemento);

    public function removeComplemento($complemento);
}