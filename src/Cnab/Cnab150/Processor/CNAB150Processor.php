<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab150\Processor;

use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab150\Detail;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab150\Header;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab150\Trailer;
use Umbrella\Ya\RetornoBoleto\Cnab\ComposableInterface;
use Umbrella\Ya\RetornoBoleto\LoteInterface;
use Umbrella\Ya\RetornoBoleto\RetornoInterface;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Empresa;

/**
 * Classe para leitura_arquivos_retorno_cobranças_padrão CNAB150.<br/>
 * Layout Padrão Febraban 150 posições<br/>
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class CNAB150Processor extends AbstractProcessor
{
    /**
     * @property int HEADER_ARQUIVO Define o valor que identifica uma coluna do tipo HEADER DE ARQUIVO
     */
    const HEADER_ARQUIVO = 'A';

    /**
     * @property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE
     */
    const DETALHE = 'G';

    /**
     * @property int TRAILER_ARQUIVO Define o valor que identifica uma coluna do tipo TRAILER DE ARQUIVO
     */
    const TRAILER_ARQUIVO = 'Z';

    public function createHeader()
    {
        return new Header();
    }

    protected function processarHeaderArquivo($linha)
    {
        $header = $this->createHeader();

        $header
            ->setRegistro($linha->substr(1, 1)->trim())
            ->setRemessa($linha->substr(2, 1)->trim())
            ->setConvenio($linha->substr(3, 20)->trim());

        $empresa = new Empresa();
        $empresa
            ->setNome($linha->substr(23, 20)->trim());

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(43, 3)->trim())
            ->setNome($linha->substr(46, 20)->trim());

        $header
            ->setDataGeracao($this->createDateTime($linha->substr(66, 8)->trim(), "Ymd"))
            ->setSequencialRet($linha->substr(74, 6)->trim())
            ->setVersaoLayout($linha->substr(80, 2)->trim())
            ->setCodBarras($linha->substr(82, 17)->trim())
            ->setFiller($linha->substr(99, 52)->trim());

        $cedente = new Cedente();
        $cedente->setBanco($banco);

        $header
            ->setCedente($cedente)
            ->setEmpresa($empresa);

        return $header;
    }

    protected function processarDetalhe($linha)
    {
        $detail = new Detail();

        $detail
            ->setRegistro($linha->substr(1, 1)->trim())
            ->setDataPagamento($this->createDateTime($linha->substr(22, 8)->trim(), "Ymd"))
            ->setDataCredito($this->createDateTime($linha->substr(30, 8)->trim(), "Ymd"))
            ->setCodBarras($linha->substr(38, 44)->trim())
            ->setValorRecebido($linha->substr(82, 10)->trim())
            ->setValorTarifa($linha->substr(94, 5)->trim())
            ->setNumeroSequencial($linha->substr(101, 8)->trim())
            ->setCodigoAgenciaArrecadadora($linha->substr(109, 8)->trim())
            ->setFormaArrecadacao($linha->substr(117, 1)->trim())
            ->setNumeroAutenticacao($linha->substr(118, 23)->trim())
            ->setFormaPagamento($linha->substr(141, 1)->trim())
            ->setFiller($linha->substr(142, 9)->trim());

        $banco = new Banco();
        $banco
            ->setAgencia($linha->substr(2, 4)->trim())
            ->setConta($linha->substr(6, 14)->trim())
            ->setDvConta($linha->substr(20, 1)->trim());

        $cedente = new Cedente();
        $cedente->setBanco($banco);

        $detail->setCedente($cedente);

        return $detail;
    }

    protected function processarTrailerArquivo($linha)
    {
        $trailer = new Trailer();

        $trailer
            ->setRegistro($linha->substr(1, 1)->trim())
            ->setQuantidadeRegistros($linha->substr(2, 6)->trim())
            ->setValorTotal($linha->substr(8, 17)->trim())
            ->setFiller($linha->substr(25, 126)->trim());

        return $trailer;
    }

    /**
     * Processa uma linha_arquivo_retorno.
     * @param int $numLn Número_linha a ser processada
     * @param string $linha String contendo a linha a ser processada
     * @return array Retorna um vetor associativo contendo os valores_linha processada.
     */
    public function processarLinha($numLn, Stringy $linha)
    {
        //é adicionado um espaço vazio no início_linha para que
        //possamos trabalhar com índices iniciando_1, no lugar_zero,
        //e assim, ter os valores_posição_campos exatamente
        //como no manual CNAB150
        $linha = $linha->insert(" ", 0);
        $tipoLn = $linha->substr(1, 1)->trim();

        $this->needToCreateLote = false;
        if ((string)$tipoLn == self::HEADER_ARQUIVO) {
            $this->needToCreateLote = true;
            $vlinha = $this->processarHeaderArquivo($linha);
        } else if ((string)$tipoLn == self::DETALHE) {
            $vlinha = $this->processarDetalhe($linha);
        } else if ((string)$tipoLn == self::TRAILER_ARQUIVO) {
            $vlinha = $this->processarTrailerArquivo($linha);
        }

        return $vlinha;
    }

    public function processCnab(RetornoInterface $retorno, ComposableInterface $composable, LoteInterface $lote = null)
    {
        switch ($composable->getRegistro()) {
            case self::HEADER_ARQUIVO:
                $retorno->setHeader($composable);
                break;

            case self::TRAILER_ARQUIVO:
                $retorno->setTrailer($composable);
                break;

            case self::DETALHE:
                $lote->addDetail($composable);
                break;
        }
    }
}
