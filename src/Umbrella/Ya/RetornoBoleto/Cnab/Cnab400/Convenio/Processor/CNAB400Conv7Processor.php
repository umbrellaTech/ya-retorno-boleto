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
            ->addComplemento(substr($linha, 108, 42))
            ->setConvenio(substr($linha, 150, 7))
            ->addComplemento(substr($linha, 108, 42))
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
            ->setConvenio(substr($linha, 32, 7))
            ->setControle(substr($linha, 38, 25))
            ->setNossoNumero(substr($linha, 64, 17))
            ->setTipoCobranca(substr($linha, 81, 1))
            ->setTipoCobrancaCmd72(substr($linha, 82, 1))
            ->setDiasCalculo(substr($linha, 83, 4))
            ->setNatureza(substr($linha, 87, 2))
            ->setPrefixoTitulo(substr($linha, 89, 3))
            ->setVariacaoCarteira(substr($linha, 92, 3))
            ->setContaCaucao(substr($linha, 95, 1))
        ;
        return $detail;
    }
}
