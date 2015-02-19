<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor;

use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\DetailConvenio;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\HeaderConvenio;

/**
 * Classe para leitura de arquivos de retorno de cobranças no padrão CNAB400/CBR643 com convênio de 7 posições.<br/>
 * Layout Padrão CNAB/Febraban 400 posições<br/>.
 * Baseado na documentação para "Layout de Arquivo Retorno para convênios na faixa numérica entre 1.000.000 a 9.999.999
 * (Convênios de 7 posições). Versão Set/09" do Banco do Brasil (arquivo Doc8826BR643Pos6.pdf),
 * disponível em http://www.bb.com.br/docs/pub/emp/empl/dwn/Doc8826BR643Pos6.pdf
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class CNAB400Conv6Processor extends AbstractCNAB400Processor
{
    /**
     * @property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE 
     */
    const DETALHE = 1;

    public function createHeader()
    {
        return new HeaderConvenio();
    }

    public function createDetail()
    {
        return new DetailConvenio();
    }

    /**
     * Processa a linha header do arquivo
     * @param string $linha Linha do header de arquivo processado
     * @return string Retorna um vetor contendo os dados dos campos do header do arquivo. 
     */
    protected function processarHeaderArquivo($linha)
    {
        $header = parent::processarHeaderArquivo($linha);
        $header->setConvenio($linha->substr(41, 6)->trim())
            ->setSequencialRet($linha->substr(101, 7)->trim())
            ->addComplemento($linha->substr(108, 287)->trim());

        return $header;
    }

    /**
     * Processa uma linha detalhe do arquivo.
     * @param string $linha Linha detalhe do arquivo processado
     * @return string Retorna um vetor contendo os dados dos campos da linha detalhe. 
     */
    protected function processarDetalhe($linha)
    {
        $detail = parent::processarDetalhe($linha);
        $detail
            ->setConvenio($linha->substr(32, 6)->trim())
            ->setControle($linha->substr(38, 25)->trim())
            ->setNossoNumero($linha->substr(63, 11)->trim())
            ->setDvNossoNumero($linha->substr(74, 1)->trim())
            ->setTipoCobranca($linha->substr(75, 1)->trim())
            ->setTipoCobrancaCmd72($linha->substr(76, 1)->trim())
            ->setDiasCalculo($linha->substr(77, 4)->trim())
            ->setNatureza($linha->substr(81, 2)->trim())
            ->addUsoBanco($linha->substr(83, 3)->trim())
            ->setVariacaoCarteira($linha->substr(86, 3)->trim())
            ->setContaCaucao($linha->substr(89, 1)->trim())
            ->addUsoBanco($linha->substr(90, 5)->trim())
            ->addUsoBanco($linha->substr(95, 1)->trim())
            ->setConfirmacao($linha->substr(127, 20)->trim())
        ;
        return $detail;
    }
}
