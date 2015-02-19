<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor;

use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\DetailConvenio;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\HeaderConvenio;

/**
 * Classe para leitura de arquivos de retorno de cobranças no padrão CNAB400/CBR643 com convênio de 7 posições.<br/>
 * Layout Padrão CNAB/Febraban 400 posições<br/>.
 * Baseado na documentação para "Layout de Arquivo Retorno para convênios na
 * faixa numérica entre 1.000.000 a 9.999.999 (Convênios de 7 posições). Versão Set/09"
 * do Banco do Brasil (arquivo Doc2628CBR643Pos7.pdf),
 * disponível em http://www.bb.com.br/docs/pub/emp/empl/dwn/Doc2628CBR643Pos7.pdf
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class CNAB400Conv7Processor extends AbstractCNAB400Processor
{
    /**
     * @property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE 
     */
    const DETALHE = 7;

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
        $header
            ->addComplemento($linha->substr(108, 42)->trim())
            ->setConvenio($linha->substr(150, 7)->trim())
            ->addComplemento($linha->substr(108, 42)->trim())
        ;

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
            ->setConvenio($linha->substr(32, 7)->trim())
            ->setControle($linha->substr(38, 25)->trim())
            ->setNossoNumero($linha->substr(64, 17)->trim())
            ->setTipoCobranca($linha->substr(81, 1)->trim())
            ->setTipoCobrancaCmd72($linha->substr(82, 1)->trim())
            ->setDiasCalculo($linha->substr(83, 4)->trim())
            ->setNatureza($linha->substr(87, 2)->trim())
            ->setPrefixoTitulo($linha->substr(89, 3)->trim())
            ->setVariacaoCarteira($linha->substr(92, 3)->trim())
            ->setContaCaucao($linha->substr(95, 1)->trim())
        ;
        return $detail;
    }
}
