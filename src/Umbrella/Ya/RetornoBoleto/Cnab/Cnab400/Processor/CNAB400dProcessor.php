<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Processor;

use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\DetailConvenio;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\HeaderConvenio;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Trailer;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabDetail;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabHeader;
use Umbrella\Ya\RetornoBoleto\Cnab\ICnabTrailer;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;
use Umbrella\Ya\RetornoBoleto\Exception\EmptyLineException;
use Umbrella\Ya\RetornoBoleto\Exception\InvalidPositionException;
use Umbrella\Ya\RetornoBoleto\ILote;
use Umbrella\Ya\RetornoBoleto\IRetorno;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Cobranca;

/**
 * Classe para leitura_arquivos_retorno_cobranças_padrão CNAB400.<br/>
 * Layout Padrão CNAB/Febraban 400 posições<br/>.
 * Baseado na documentação para "Layout de Arquivo Retorno para Convênios
 * na faixa numérica entre 000.001 a 999.999 (Convênios de até 6 posições). Versão Set/09"
 * do Banco do Brasil (arquivo CBR643-6_posicoes.pdf)
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class CNAB400Processor extends AbstractProcessor
{
    /**
     * @property int HEADER_ARQUIVO Define o valor que identifica uma coluna do tipo HEADER DE ARQUIVO 
     */
    const HEADER_ARQUIVO = 0;

    /**
     * @property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE 
     */
    const DETALHE = 1;

    /**
     * @property int TRAILER_ARQUIVO Define o valor que identifica uma coluna do tipo TRAILER DE ARQUIVO 
     */
    const TRAILER_ARQUIVO = 9;

    public function createHeader()
    {
        return new HeaderConvenio();
    }

    public function createDetail()
    {
        return new DetailConvenio();
    }

    public function createTrailer()
    {
        return new Trailer();
    }

    /**
     * Processa a linha header do arquivo
     * @param string $linha Linha do header de arquivo processado
     * @return ICnabHeader Retorna um vetor contendo os dados dos campos do header do arquivo. 
     */
    public function processarHeaderArquivo($linha)
    {
        $header = $this->createHeader();
        //X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
        $header
            ->setRegistro(substr($linha, 1, 1))
            ->setTipoOperacao(substr($linha, 2, 1))
            ->setIdTipoOperacao(substr($linha, 3, 7))
            ->setIdTipoServico(substr($linha, 10, 2))
            ->setTipoServico(substr($linha, 12, 8))
            ->addComplemento(substr($linha, 20, 7));

        $bancoArray = array();
        preg_match('^([\d]{3})(.+)', substr($linha, 77, 18), $bancoArray);

        $banco = new Banco();
        $banco
            ->setCod($bancoArray[0])
            ->setNome($bancoArray[1])
            ->setAgencia(substr($linha, 27, 4))
            ->setDvAgencia(substr($linha, 31, 1))
            ->setConta(substr($linha, 32, 8))
            ->setDvConta(substr($linha, 40, 1));


        $cedente = new Cedente();
        $cedente->setBanco($banco)
            ->setNome(substr($linha, 47, 30));

        $header
            ->setCedente($cedente)
            ->setConvenio(substr($linha, 41, 6))
            ->setDataGravacao($this->formataData(substr($linha, 95, 6)))
            ->setSequencialReg(substr($linha, 395, 6))
            ->setSequencialRet(substr($linha, 101, 7))
            ->addComplemento(substr($linha, 108, 287))
        ;

        return $header;
    }

    /**
     * Processa uma linha detalhe do arquivo.
     * @param string $linha Linha detalhe do arquivo processado
     * @return ICnabDetail Retorna um vetor contendo os dados dos campos da linha detalhe. 
     */
    public function processarDetalhe($linha)
    {
        $detail = $this->createDetail();
        $bancoEmissor = new Banco();
        $bancoEmissor
            ->setAgencia(substr($linha, 18, 4))
            ->setDvAgencia(substr($linha, 22, 1))
            ->setConta(substr($linha, 23, 8))
            ->setDvConta(substr($linha, 31, 1));

        $bancoRecebedor = new Banco();
        $bancoRecebedor
            ->setCod(substr($linha, 166, 3))
            ->setAgencia(substr($linha, 169, 4))
            ->setDvAgencia(substr($linha, 173, 1));

        $detail
            ->setBancoEmissor($bancoEmissor)
            ->setBancoRecebedor($bancoRecebedor)
            ->setRegistro(substr($linha, 1, 1))
            ->addZeros(substr($linha, 2, 2))
            ->addZeros(substr($linha, 4, 14))
            ->addConvenio(substr($linha, 32, 6))
            ->addControle(substr($linha, 38, 25))
            ->addNossoNumero(substr($linha, 63, 11))
            ->setTipoCobranca(substr($linha, 75, 1))
            ->setTipoCobrancaCmd72(substr($linha, 76, 1))
            ->setDiasCalculo(substr($linha, 77, 4))
            ->setNatureza(substr($linha, 81, 2))
            ->addUsoBanco(substr($linha, 83, 3))
            ->setVariacaoCarteira(substr($linha, 86, 3))
            ->setContaCaucao(substr($linha, 89, 1))
            ->addUsoBanco(substr($linha, 90, 5))
            ->addUsoBanco(substr($linha, 95, 1))
            ->setConfirmacao(substr($linha, 127, 20))
            ->setTaxaDesconto($this->formataNumero(substr($linha, 96, 5)))
            ->setTaxaIof(substr($linha, 101, 5))
            ->addBranco(substr($linha, 106, 1))
            ->setCateira(substr($linha, 107, 2))
            ->setComando(substr($linha, 109, 2))
            ->setDataEntradaLiquidacao($this->formataData(substr($linha, 111, 6)))
            ->setNumTitulo(substr($linha, 117, 10))
            ->setDataVencimento(substr($linha, 147, 6))
            ->setValor($this->formataNumero(substr($linha, 153, 13)))
            ->setEspecie(substr($linha, 174, 2))
            ->setDataCredito(substr($linha, 176, 6))
            ->setValorTarifa($this->formataNumero(substr($linha, 182, 7)))
            ->setOutrasDespesas($this->formataNumero(substr($linha, 189, 13)))
            ->setJurosDesconto($this->formataNumero(substr($linha, 202, 13)))
            ->setIofDesconto($this->formataNumero(substr($linha, 215, 13)))
            ->setValorAbatimento($this->formataNumero(substr($linha, 228, 13)))
            ->setDescontoConcedido($this->formataNumero(substr($linha, 241, 13)))
            ->setValorRecebido($this->formataNumero(substr($linha, 254, 13)))
            ->setJurosMora($this->formataNumero(substr($linha, 267, 13)))
            ->setOutrosRecebimentos($this->formataNumero(substr($linha, 280, 13)))
            ->setAbatimentoNaoAprovado($this->formataNumero(substr($linha, 293,
                                                                   13)))
            ->setValorLancamento($this->formataNumero(substr($linha, 306, 13)))
            ->setIndicativoDc(substr($linha, 319, 1))
            ->setIndicadorValor(substr($linha, 320, 1))
            ->setValorAjuste($this->formataNumero(substr($linha, 321, 12)))
            ->addBranco(substr($linha, 333, 1))
            ->addBranco(substr($linha, 334, 1))
            ->addZeros(substr($linha, 343, 6))
            ->addZeros(substr($linha, 349, 9))
            ->addZeros(substr($linha, 358, 6))
            ->addZeros(substr($linha, 364, 9))
            ->addZeros(substr($linha, 373, 6))
            ->addZeros(substr($linha, 379, 9))
            ->addBranco(substr($linha, 388, 5))
            ->setCanalPagTitulo(substr($linha, 393, 2))
            ->setSequencial(substr($linha, 395, 6))
        ;
        return $detail;
    }

    /** Processa a linha trailer do arquivo.
     * @param string $linha Linha trailer do arquivo processado
     * @return ICnabTrailer Retorna um vetor contendo os dados dos campos da linha trailer do arquivo. 
     */
    public function processarTrailerArquivo($linha)
    {
        $trailer = $this->createTrailer();

        $banco = new Banco();
        $banco->setCod(substr($linha, 5, 3));

        $simples = new Cobranca();
        $simples->setQtdTitulos(substr($linha, 18, 8))
            ->setValorTotal($this->formataNumero(substr($linha, 26, 14)))
            ->setNumAviso(substr($linha, 40, 8));

        $vinculada = new Cobranca();
        $vinculada->setQtdTitulos(substr($linha, 58, 8))
            ->setValorTotal($this->formataNumero(substr($linha, 66, 14)))
            ->setNumAviso(substr($linha, 80, 8));

        $caucionada = new Cobranca();
        $caucionada->setQtdTitulos(substr($linha, 98, 8))
            ->setValorTotal($this->formataNumero(substr($linha, 106, 14)))
            ->setNumAviso(substr($linha, 120, 8));

        $descontada = new Cobranca();
        $descontada->setQtdTitulos(substr($linha, 138, 8))
            ->setValorTotal($this->formataNumero(substr($linha, 146, 14)))
            ->setNumAviso(substr($linha, 160, 8));

        $vendor = new Cobranca();
        $vendor->setQtdTitulos(substr($linha, 218, 8))
            ->setValorTotal($this->formataNumero(substr($linha, 226, 14)))
            ->setNumAviso(substr($linha, 240, 8));

        $trailer
            ->setBanco($banco)
            ->setRegistro(substr($linha, 1, 1))
            ->setRetorno(substr($linha, 2, 1))
            ->setTipoRegistro(substr($linha, 3, 2))
            ->addBranco(substr($linha, 8, 10))
            ->setSimples($simples)
            ->setVinculada($vinculada)
            ->setCaucionada($caucionada)
            ->setDescontada($descontada)
            ->setVendor($vendor)
            ->setSequencial(substr($linha, 395, 6))
        ;
        return $trailer;
    }

    /**
     * Processa uma linha_arquivo_retorno.
     * @param int $numLn Número_linha a ser processada
     * @param string $linha String contendo a linha a ser processada
     * @return IComposable Retorna um vetor associativo contendo os valores_linha processada. 
     */
    public function processarLinha($numLn, $linha)
    {
        $tamLinha = 400; //total de caracteres das linhas do arquivo
        //o +2 é utilizado para contar o \r\n no final da linha
        //o +2 é utilizado para contar o \r\n no final da linha
        if (strlen($linha) != $tamLinha and strlen($linha) != $tamLinha + 2) {
            throw new InvalidPositionException("A linha $numLn não tem $tamLinha posições. Possui " . strlen($linha));
        }

        if (trim($linha) == "") {
            throw new EmptyLineException("A linha $numLn está vazia.");
        }

        //é adicionado um espaço vazio no início_linha para que
        //possamos trabalhar com índices iniciando_1, no lugar_zero,
        //e assim, ter os valores_posição_campos exatamente
        //como no manual CNAB400
        $linha = " $linha";
        $tipoLn = substr($linha, 1, 1);
        $composable = null;

        $this->needToCreateLote = false;
        if ($tipoLn == CNAB400Processor::HEADER_ARQUIVO) {
            $this->needToCreateLote = true;
            $composable = $this->processarHeaderArquivo($linha);
        } else if ($tipoLn == CNAB400Processor::DETALHE) {
            $composable = $this->processarDetalhe($linha);
        } else if ($tipoLn == CNAB400Processor::TRAILER_ARQUIVO) {
            $composable = $this->processarTrailerArquivo($linha);
        }

        return $composable;
    }

    public function processCnab(IRetorno $retorno, IComposable $composable,
                                ILote $lote = null)
    {
        switch ((int) $composable->getRegistro()) {
            case CNAB400Processor::HEADER_ARQUIVO:
                $retorno->setHeader($composable);
                break;

            case CNAB400Processor::TRAILER_ARQUIVO:
                $retorno->setTrailer($composable);
                break;

            default:
                $lote->addDetail($composable);
                break;
        }
    }
}