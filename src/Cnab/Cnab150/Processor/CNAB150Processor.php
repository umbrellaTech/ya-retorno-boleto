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
            ->setRegistro($linha->substr(1, 1))
            ->setRemessa($linha->substr(2, 1))
            ->setConvenio($linha->substr(3, 20));

        $empresa = new Empresa();
        $empresa
            ->setNome($linha->substr(23, 20));

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(43, 3))
            ->setNome($linha->substr(46, 20));

        $header
            ->setDataGeracao($this->createDateTime($linha->substr(66, 8), "Ymd"))
            ->setSequencialRet($linha->substr(74, 6))
            ->setVersaoLayout($linha->substr(80, 2))
            ->setCodBarras($linha->substr(82, 17))
            ->setFiller($linha->substr(99, 52));

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
            ->setRegistro($linha->substr(1, 1))
            ->setDataPagamento($this->createDateTime($linha->substr(22, 8), "Ymd"))
            ->setDataCredito($this->createDateTime($linha->substr(30, 8), "Ymd"))
            ->setCodBarras($linha->substr(38, 44))
            ->setValorRecebido($linha->substr(82, 10))
            ->setValorTarifa($linha->substr(94, 5))
            ->setNumeroSequencial($linha->substr(101, 8))
            ->setCodigoAgenciaArrecadadora($linha->substr(109, 8))
            ->setFormaArrecadacao($linha->substr(117, 1))
            ->setNumeroAutenticacao($linha->substr(118, 23))
            ->setFormaPagamento($linha->substr(141, 1))
            ->setFiller($linha->substr(142, 9));

        $banco = new Banco();
        $banco
            ->setAgencia($linha->substr(2, 4))
            ->setConta($linha->substr(6, 14))
            ->setDvConta($linha->substr(20, 1));

        $cedente = new Cedente();
        $cedente->setBanco($banco);

        $detail->setCedente($cedente);

        return $detail;
    }

    protected function processarTrailerArquivo($linha)
    {
        $trailer = new Trailer();

        $trailer
            ->setRegistro($linha->substr(1, 1))
            ->setQuantidadeRegistros($linha->substr(2, 6))
            ->setValorTotal($linha->substr(8, 17))
            ->setFiller($linha->substr(25, 126));

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
        $tipoLn = $linha->substr(1, 1);

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
