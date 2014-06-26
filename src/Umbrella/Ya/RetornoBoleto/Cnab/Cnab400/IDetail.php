<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400;

use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;

interface IDetail extends ICnabDetail, ICnab400
{

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

    /**
     * @return Banco
     */
    public function getBancoEmissor();

    /**
     * @return Cedente
     */
    public function getCedente();

    /**
     * @return Detail
     */
    public function setTaxaDesconto($taxaDesconto);

    /**
     * @return Detail
     */
    public function setTaxaIof($taxaIof);

    /**
     * @return Detail
     */
    public function setCateira($cateira);

    /**
     * @return Detail
     */
    public function setComando($comando);

    /**
     * @return Detail
     */
    public function setDataOcorrencia($dataOcorrencia);

    /**
     * @return Detail
     */
    public function setNumTitulo($numTitulo);

    /**
     * @return Detail
     */
    public function setDataVencimento($dataVencimento);

    /**
     * @return Detail
     */
    public function setValor($valor);

    /**
     * @return Detail
     */
    public function setEspecie($especie);

    /**
     * @return Detail
     */
    public function setDataCredito($dataCredito);

    /**
     * @return Detail
     */
    public function setValorTarifa($valorTarifa);

    /**
     * @return Detail
     */
    public function setOutrasDespesas($outrasDespesas);

    /**
     * @return Detail
     */
    public function setJurosDesconto($jurosDesconto);

    /**
     * @return Detail
     */
    public function setIofDesconto($iofDesconto);

    /**
     * @return Detail
     */
    public function setValorAbatimento($valorAbatimento);

    /**
     * @return Detail
     */
    public function setDescontoConcedido($descontoConcedido);

    /**
     * @return Detail
     */
    public function setValorRecebido($valorRecebido);

    /**
     * @return Detail
     */
    public function setJurosMora($jurosMora);

    /**
     * @return Detail
     */
    public function setOutrosRecebimentos($outrosRecebimentos);

    /**
     * @return Detail
     */
    public function setAbatimentoNaoAprovado($abatimentoNaoAprovado);

    /**
     * @return Detail
     */
    public function setValorLancamento($valorLancamento);

    /**
     * @return Detail
     */
    public function setIndicativoDc($indicativoDc);

    /**
     * @return Detail
     */
    public function setValorAjuste($valorAjuste);

    /**
     * @return Detail
     */
    public function setCanalPagTitulo($canalPagTitulo);

    /**
     * @return Detail
     */
    public function setSequencial($sequencial);

    /**
     * @return Detail
     */
    public function setBancoEmissor(Banco $bancoEmissor);

    /**
     * @return Detail
     */
    public function setCedente(Cedente $cedente);

    /**
     * @return Banco
     */
    public function getBancoRecebedor();

    /**
     * @return Detail
     */
    public function setBancoRecebedor(Banco $bancoRecebedor);

    public function getIndicadorValor();

    /**
     * @return Detail
     */
    public function setIndicadorValor($indicadorValor);
}