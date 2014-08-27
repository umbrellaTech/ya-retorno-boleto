<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Processor;

use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Cnab240Interface;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Detail;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Header;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\HeaderLote;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Trailer;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\TrailerLote;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor\AbstractCNAB400Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\ComposableInterface;
use Umbrella\Ya\RetornoBoleto\LoteInterface;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Empresa;
use Umbrella\Ya\RetornoBoleto\Model\Endereco;
use Umbrella\Ya\RetornoBoleto\RetornoInterface;

/**
 * Classe para leitura_arquivos_retorno_cobranças_padrão CNAB240.<br/>
 * Layout Padrão Febraban 240 posições V08.4 de 01/09/2009<br/>
 * http://www.febraban.org.br
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class CNAB240Processor extends AbstractProcessor
{
    /**
     * @property int HEADER_ARQUIVO Define o valor que identifica uma coluna do tipo HEADER DE ARQUIVO 
     */
    const HEADER_ARQUIVO = 0;

    /**
     * @property int HEADER_LOTE Define o valor que identifica uma coluna do tipo HEADER DE LOTE 
     */
    const HEADER_LOTE = 1;

    /**
     * @property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE 
     */
    const DETALHE = 3;

    /**
     * @property int TRAILER_LOTE Define o valor que identifica uma coluna do tipo TRAILER DEs LOTE 
     */
    const TRAILER_LOTE = 5;

    /**
     * @property int TRAILER_ARQUIVO Define o valor que identifica uma coluna do tipo TRAILER DE ARQUIVO 
     */
    const TRAILER_ARQUIVO = 9;

    public function createHeader()
    {
        return new Header();
    }

    protected function processarHeaderArquivo($linha)
    {
        $header = $this->createHeader();
        //X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
        $header
            ->setRegistro(substr($linha, 8, 1))
            ->setLote(substr($linha, 4, 4))
            ->addCnab(substr($linha, 9, 9))
            ->addCnab(substr($linha, 133, 10))
            ->addCnab(substr($linha, 212, 29))
            ->setConvenio(substr($linha, 33, 20))
            ->setCodArquivo(substr($linha, 143, 1))
        ;

        $header->setDataGeracao($this->createDateTime(substr($linha, 144, 8) . " " . substr($linha, 152, 6)))
            ->setSequencialRet(substr($linha, 158, 6))
            ->setVersaoLayout(substr($linha, 164, 3))
        ;

        $empresa = new Empresa();
        $empresa
            ->setTipoInscricao(substr($linha, 18, 1))
            ->setNumInscricao(substr($linha, 19, 14))
            ->setNome(substr($linha, 73, 30))
            ->addReservado(substr($linha, 192, 20))
        ;

        $banco = new Banco();
        $banco
            ->setNome(substr($linha, 103, 30))
            ->setAgencia(substr($linha, 53, 5))
            ->setDvAgencia(substr($linha, 58, 1))
            ->setConta(substr($linha, 59, 12))
            ->setDvConta(substr($linha, 71, 1))
            ->setDvAgenciaConta(substr($linha, 72, 1))
            ->addReservado(substr($linha, 192, 20))
        ;


        $cedente = new Cedente();
        $cedente->setBanco($banco);

        $header
            ->setCedente($cedente)
            ->setEmpresa($empresa)
        ;

        return $header;
    }

    protected function processarHeaderLote($linha)
    {
        $header = new HeaderLote();

        $header
            ->setRegistro(substr($linha, 8, 1))
            ->setLote(substr($linha, 4, 4))
            ->setOperacao(substr($linha, 9, 1))
            ->setServico(substr($linha, 10, 2))
            ->setFormaLancamento(substr($linha, 12, 2))
            ->setVersaoLayout(substr($linha, 14, 3))
            ->addCnab(substr($linha, 17, 1))
            ->addCnab(substr($linha, 223, 8))
            ->addOcorrencia(substr($linha, 231, 10))
            ->setConvenio(substr($linha, 33, 20))
            ->addMensagem(substr($linha, 103, 40))
        ;

        $endereco = new Endereco();
        $endereco
            ->setLogradourdo(substr($linha, 143, 30))
            ->setNumero(substr($linha, 173, 5))
            ->setComplemento(substr($linha, 178, 15))
            ->setCidade(substr($linha, 193, 20))
            ->setCep(substr($linha, 213, 5))
            ->setComplementoCep(substr($linha, 218, 3))
            ->setEstado(substr($linha, 221, 2))
        ;
        $empresa = new Empresa();
        $empresa
            ->setEndereco($endereco)
            ->setTipoInscricao(substr($linha, 18, 1))
            ->setNumInscricao(substr($linha, 19, 14))
            ->setNome(substr($linha, 73, 30))
        ;

        $banco = new Banco();
        $banco
            ->setCod(substr($linha, 1, 3))
            ->setNome(substr($linha, 103, 30))
            ->setAgencia(substr($linha, 53, 5))
            ->setDvAgencia(substr($linha, 58, 1))
            ->setConta(substr($linha, 59, 12))
            ->setDvConta(substr($linha, 71, 1))
            ->setDvAgenciaConta(substr($linha, 72, 1))
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
        $detail = new Detail;

        $detail
            ->setRegistro(substr($linha, 8, 1))
            ->setLote(substr($linha, 4, 4))
            ->setNumRegistroLote(substr($linha, 9, 5))
            ->setSegmento(substr($linha, 14, 1))
            ->setTipoMovimento(substr($linha, 15, 1))
            ->setCodMovimento(substr($linha, 16, 2))
            ->setCodBarras(substr($linha, 18, 44))
            ->setDataVencimento($this->createDate(substr($linha, 92, 8)))
            ->setValorTitulo(substr($linha, 100, 13))
            ->setDesconto(substr($linha, 115, 13))
            ->setAcrescimos(substr($linha, 130, 13))
            ->setDataPagamento($this->createDate(substr($linha, 145, 8)))
            ->setValorPagamento(substr($linha, 153, 13))
            ->setQuantidadeMoeda(substr($linha, 168, 10))
            ->setReferenciaSacado(substr($linha, 183, 20))
            ->setNossoNumero(substr($linha, 203, 20))
            ->setCodMoeda(substr($linha, 223, 2))
            ->addCnab(substr($linha, 225, 6))
            ->addOcorrencia(substr($linha, 231, 10))
        ;

        $banco = new Banco();
        $banco
            ->setCod(substr($linha, 1, 3))
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

    protected function processarTrailerLote($linha)
    {
        $trailer = new TrailerLote();

        $banco = new Banco();
        $banco
            ->setCod(substr($linha, 1, 3))
        ;

        $cedente = new Cedente();
        $cedente
            ->setNome(substr($linha, 62, 30))
            ->setBanco($banco)
        ;

        $trailer
            ->setLote(substr($linha, 4, 4))
            ->setRegistro(substr($linha, 8, 1))
            ->addCnab(substr($linha, 9, 9))
            ->setQuantidadeRegistros(substr($linha, 18, 6))
            ->setValor(substr($linha, 24, 16))
            ->setQuantidadeMoedas(substr($linha, 42, 13))
            ->setNumAvisoDepbito(substr($linha, 60, 6))
            ->addCnab(substr($linha, 66, 165))
            ->addOcorrencia(substr($linha, 231, 10))
        ;

        return $trailer;
    }

    protected function processarTrailerArquivo($linha)
    {
        $trailer = new Trailer();

        $banco = new Banco();
        $banco
            ->setCod(substr($linha, 1, 3))
        ;

        $cedente = new Cedente();
        $cedente
            ->setNome(substr($linha, 62, 30))
            ->setBanco($banco)
        ;

        $trailer
            ->setLote(substr($linha, 4, 4))
            ->setRegistro(substr($linha, 8, 1))
            ->addCnab(substr($linha, 9, 9))
            ->setQuantidadeLotes(substr($linha, 18, 6))
            ->setQuantidadeRegistros(substr($linha, 24, 6))
            ->setQuantidadeContasConc(substr($linha, 30, 6))
            ->addCnab(substr($linha, 36, 205))
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
        //como no manual CNAB240
        $linha = " $linha";
        $tipoLn = substr($linha, 8, 1);

        $this->needToCreateLote = false;
        if ($tipoLn == CNAB240Processor::HEADER_ARQUIVO) {
            $vlinha = $this->processarHeaderArquivo($linha);
        } else if ($tipoLn == CNAB240Processor::HEADER_LOTE) {
            $this->needToCreateLote = true;
            $vlinha = $this->processarHeaderLote($linha);
        } else if ($tipoLn == CNAB240Processor::DETALHE) {
            $vlinha = $this->processarDetalhe($linha);
        } else if ($tipoLn == CNAB240Processor::TRAILER_LOTE) {
            $vlinha = $this->processarTrailerLote($linha);
        } else if ($tipoLn == CNAB240Processor::TRAILER_ARQUIVO) {
            $vlinha = $this->processarTrailerArquivo($linha);
        }
        return $vlinha;
    }

    public function processCnab(RetornoInterface $retorno, ComposableInterface $composable, LoteInterface $lote = null)
    {
        switch ((int) $composable->getRegistro()) {
            case AbstractCNAB400Processor::HEADER_ARQUIVO:
                $retorno->setHeader($composable);
                break;

            case self::TRAILER_ARQUIVO:
                $retorno->setTrailer($composable);
                break;

            case self::HEADER_LOTE:
                if ($composable instanceof Cnab240Interface) {
                    $lote->setHeader($composable);
                } else {
                    $lote->addDetail($composable);
                }
                break;

            case self::TRAILER_LOTE:
                $lote->setTrailer($composable);
                break;

            default:
                $lote->addDetail($composable);
                break;
        }
    }
}
