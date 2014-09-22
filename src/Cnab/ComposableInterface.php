<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab;

use Easy\Collections\VectorInterface;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Empresa;

interface ComposableInterface
{

    public function addCnab($cnab);

    public function removeCnab($cnab);

    public function getCnabs();

    public function setCnabs(VectorInterface $cnabs);

    public function getRegistro();

    public function getLote();

    public function getCedente();

    /**
     * @param string $registro
     */
    public function setRegistro($registro);

    /**
     * @param string $lote
     */
    public function setLote($lote);

    public function setCedente(Cedente $cedente);

    public function getOcorrencias();

    public function setOcorrencias(VectorInterface $ocorrencias);

    public function getEmpresa();

    public function setEmpresa(Empresa $empresa);

    /**
     * @param string $ocorrencia
     */
    public function addOcorrencia($ocorrencia);

    public function removeOcorrencia($ocorrencia);
}
