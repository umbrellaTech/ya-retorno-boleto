<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab150\Processor;

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
            ->setRegistro(substr($linha, 1, 1))
            ->setRemessa(substr($linha, 2, 1))
            ->setConvenio(substr($linha, 3, 20))
        ;

        $empresa = new Empresa();
        $empresa
            ->setNome(substr($linha, 23, 20))
        ;

        $banco = new Banco();
        $banco
            ->setCod(substr($linha, 43, 3))
            ->setNome(substr($linha, 46, 20))
        ;

        $header
            ->setDataGeracao($this->createDateTime(substr($linha, 66, 8), "Ymd"))
            ->setSequencialRet(substr($linha, 74, 6))
            ->setVersaoLayout(substr($linha, 80, 2))
            ->setCodBarras(substr($linha, 82, 17))
            ->setFiller(substr($linha, 99, 52))
        ;

        $cedente = new Cedente();
        $cedente->setBanco($banco);

        $header
            ->setCedente($cedente)
            ->setEmpresa($empresa)
        ;

        return $header;
    }

    protected function processarDetalhe($linha)
    {
        $detail = new Detail();

        $detail
            ->setRegistro(substr($linha, 1, 1))
            ->setDataPagamento($this->createDateTime(substr($linha, 22, 8), "Ymd"))
            ->setDataCredito($this->createDateTime(substr($linha, 30, 8), "Ymd"))
            ->setCodBarras(substr($linha, 38, 44))
            ->setValorRecebido(substr($linha, 82, 10))
            ->setValorTarifa(substr($linha, 94, 5))
            ->setNumeroSequencial(substr($linha, 101, 8))
            ->setCodigoAgenciaArrecadadora(substr($linha, 109, 8))
            ->setFormaArrecadacao(substr($linha, 117, 1))
            ->setNumeroAutenticacao(substr($linha, 118, 23))
            ->setFormaPagamento(substr($linha, 141, 1))
            ->setFiller(substr($linha, 142, 9))
        ;

        $banco = new Banco();
        $banco
            ->setAgencia(substr($linha, 2, 4))
            ->setConta(substr($linha, 6, 14))
            ->setDvConta(substr($linha, 20, 1))
        ;

        $cedente = new Cedente();
        $cedente
            ->setNome(substr($linha, 62, 30))
            ->setBanco($banco);

        $detail
            ->setCedente($cedente)
        ;

        return $detail;
    }

    protected function processarTrailerArquivo($linha)
    {
        $trailer = new Trailer();

        $trailer
            ->setRegistro(substr($linha, 1, 1))
            ->setQuantidadeRegistros(substr($linha, 2, 6))
            ->setValorTotal(substr($linha, 8, 17))
            ->setFiller(substr($linha, 25, 126))
        ;

        return $trailer;
    }

    /**
     * Processa uma linha_arquivo_retorno.
     * @param int $numLn Número_linha a ser processada
     * @param string $linha String contendo a linha a ser processada
     * @return array Retorna um vetor associativo contendo os valores_linha processada. 
     */
    public function processarLinha($numLn, $linha)
    {
        //é adicionado um espaço vazio no início_linha para que
        //possamos trabalhar com índices iniciando_1, no lugar_zero,
        //e assim, ter os valores_posição_campos exatamente
        //como no manual CNAB150
        $linha = " $linha";
        $tipoLn = substr($linha, 1, 1);

        $this->needToCreateLote = false;
        if ($tipoLn == self::HEADER_ARQUIVO) {
            $this->needToCreateLote = true;
            $vlinha = $this->processarHeaderArquivo($linha);
        } else if ($tipoLn == self::DETALHE) {
            $vlinha = $this->processarDetalhe($linha);
        } else if ($tipoLn == self::TRAILER_ARQUIVO) {
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
