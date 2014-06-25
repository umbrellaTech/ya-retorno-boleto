<?php

namespace Umbrella\Ya\RetornoBoleto;

use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;

interface IDetail
{

    public function getRegistro();

    public function getTaxaDesconto();

    public function getTaxaIof();

    public function getCateira();

    public function getComando();

    public function getDataOcorrencia();

    public function getNumTitulo();

    public function getDataVencimento();

    public function getValor();

    public function getEspecie();

    public function getDataCredito();

    public function getValorTarifa();

    public function getOutrasDespesas();

    public function getJurosDesconto();

    public function getIofDesconto();

    public function getValorAbatimento();

    public function getDescontoConcedido();

    public function getValorRecebido();

    public function getJurosMora();

    public function getOutrosRecebimentos();

    public function getAbatimentoNaoAprovado();

    public function getValorLancamento();

    public function getIndicativoDc();

    public function getValorAjuste();

    public function getCanalPagTitulo();

    public function getSequencial();

    public function getBancoEmissor();

    public function getCedente();

    public function setRegistro($registro);

    public function setTaxaDesconto($taxaDesconto);

    public function setTaxaIof($taxaIof);

    public function setCateira($cateira);

    public function setComando($comando);

    public function setDataOcorrencia($dataOcorrencia);

    public function setNumTitulo($numTitulo);

    public function setDataVencimento($dataVencimento);

    public function setValor($valor);

    public function setEspecie($especie);

    public function setDataCredito($dataCredito);

    public function setValorTarifa($valorTarifa);

    public function setOutrasDespesas($outrasDespesas);

    public function setJurosDesconto($jurosDesconto);

    public function setIofDesconto($iofDesconto);

    public function setValorAbatimento($valorAbatimento);

    public function setDescontoConcedido($descontoConcedido);

    public function setValorRecebido($valorRecebido);

    public function setJurosMora($jurosMora);

    public function setOutrosRecebimentos($outrosRecebimentos);

    public function setAbatimentoNaoAprovado($abatimentoNaoAprovado);

    public function setValorLancamento($valorLancamento);

    public function setIndicativoDc($indicativoDc);

    public function setValorAjuste($valorAjuste);

    public function setCanalPagTitulo($canalPagTitulo);

    public function setSequencial($sequencial);

    public function setBancoEmissor(Banco $bancoEmissor);

    public function setCedente(Cedente $cedente);

    public function getBancoRecebedor();

    public function setBancoRecebedor(Banco $bancoRecebedor);

    public function getIndicadorValor();

    public function setIndicadorValor($indicadorValor);
}