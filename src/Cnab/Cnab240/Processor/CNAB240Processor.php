<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Processor;

use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Header;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\HeaderLote;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Trailer;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\TrailerLote;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor\AbstractCNAB400Processor;
use Umbrella\Ya\RetornoBoleto\Cnab\CnabHeaderInterface;
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
            ->setRegistro($linha->substr(8, 1))
            ->setLote($linha->substr(4, 4))
            ->addCnab($linha->substr(9, 9))
            ->addCnab($linha->substr(133, 10))
            ->addCnab($linha->substr(212, 29))
            ->setConvenio($linha->substr(33, 20))
            ->setCodArquivo($linha->substr(143, 1));

        $header->setDataGeracao($this->createDateTime($linha->substr(144, 8) . " " . $linha->substr(152, 6)))
            ->setSequencialRet($linha->substr(158, 6))
            ->setVersaoLayout($linha->substr(164, 3))
            ->setDensidade($linha->substr(167, 5));

        $empresa = new Empresa();
        $empresa
            ->setTipoInscricao($linha->substr(18, 1))
            ->setNumInscricao($linha->substr(19, 14))
            ->setNome($linha->substr(73, 30))
            ->addReservado($linha->substr(192, 20));

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3))
            ->setNome($linha->substr(103, 30))
            ->setAgencia($linha->substr(53, 5))
            ->setDvAgencia($linha->substr(58, 1))
            ->setConta($linha->substr(59, 12))
            ->setDvConta($linha->substr(71, 1))
            ->setDvAgenciaConta($linha->substr(72, 1))
            ->addReservado($linha->substr(172, 20));


        $cedente = new Cedente();
        $cedente->setBanco($banco);

        $header
            ->setCedente($cedente)
            ->setEmpresa($empresa);

        return $header;
    }

    protected function processarHeaderLote($linha)
    {
        $header = new HeaderLote();

        $header
            ->setRegistro($linha->substr(8, 1))
            ->setLote($linha->substr(4, 4))
            ->setOperacao($linha->substr(9, 1))
            ->setServico($linha->substr(10, 2))
            ->setFormaLancamento($linha->substr(12, 2))
            ->setVersaoLayout($linha->substr(14, 3))
            ->addCnab($linha->substr(17, 1))
            ->addCnab($linha->substr(223, 8))
            ->addOcorrencia($linha->substr(231, 10))
            ->setConvenio($linha->substr(33, 20))
            ->addMensagem($linha->substr(103, 40));

        $endereco = new Endereco();
        $endereco
            ->setLogradourdo($linha->substr(143, 30))
            ->setNumero($linha->substr(173, 5))
            ->setComplemento($linha->substr(178, 15))
            ->setCidade($linha->substr(193, 20))
            ->setCep($linha->substr(213, 5))
            ->setComplementoCep($linha->substr(218, 3))
            ->setEstado($linha->substr(221, 2));
        $empresa = new Empresa();
        $empresa
            ->setEndereco($endereco)
            ->setTipoInscricao($linha->substr(18, 1))
            ->setNumInscricao($linha->substr(19, 14))
            ->setNome($linha->substr(73, 30));

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3))
            ->setNome($linha->substr(103, 30))
            ->setAgencia($linha->substr(53, 5))
            ->setDvAgencia($linha->substr(58, 1))
            ->setConta($linha->substr(59, 12))
            ->setDvConta($linha->substr(71, 1))
            ->setDvAgenciaConta($linha->substr(72, 1));


        $cedente = new Cedente();
        $cedente->setBanco($banco);

        $header
            ->setCedente($cedente)
            ->setEmpresa($empresa);

        return $header;
    }

    protected function processarDetalhe($linha)
    {
        $factory = new \Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento\SegmentoFactory();
        $segmento = $linha->substr(14, 1);
        return $factory->getDetail($segmento)->buildDetail($linha);
    }

    protected function processarTrailerLote($linha)
    {
        $trailer = new TrailerLote();

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3));

        $cedente = new Cedente();
        $cedente
            ->setNome($linha->substr(62, 30))
            ->setBanco($banco);

        $trailer
            ->setLote($linha->substr(4, 4))
            ->setRegistro($linha->substr(8, 1))
            ->addCnab($linha->substr(9, 9))
            ->setQuantidadeRegistros($linha->substr(18, 6))
            ->setValor($linha->substr(24, 16))
            ->setQuantidadeMoedas($linha->substr(42, 13))
            ->setNumAvisoDepbito($linha->substr(60, 6))
            ->addCnab($linha->substr(66, 165))
            ->addOcorrencia($linha->substr(231, 10));

        return $trailer;
    }

    protected function processarTrailerArquivo($linha)
    {
        $trailer = new Trailer();

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3));

        $cedente = new Cedente();
        $cedente
            ->setNome($linha->substr(62, 30))
            ->setBanco($banco);

        $trailer
            ->setLote($linha->substr(4, 4))
            ->setRegistro($linha->substr(8, 1))
            ->addCnab($linha->substr(9, 9))
            ->setQuantidadeLotes($linha->substr(18, 6))
            ->setQuantidadeRegistros($linha->substr(24, 6))
            ->setQuantidadeContasConc($linha->substr(30, 6))
            ->addCnab($linha->substr(36, 205));

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
        //como no manual CNAB240
        $linha = $linha->insert(" ", 0);
        $tipoLn = $linha->substr(8, 1);

        $this->needToCreateLote = false;
        if ((string)$tipoLn == CNAB240Processor::HEADER_ARQUIVO) {
            $vlinha = $this->processarHeaderArquivo($linha);
        } else if ((string)$tipoLn == CNAB240Processor::HEADER_LOTE) {
            $this->needToCreateLote = true;
            $vlinha = $this->processarHeaderLote($linha);
        } else if ((string)$tipoLn == CNAB240Processor::DETALHE) {
            $vlinha = $this->processarDetalhe($linha);
        } else if ((string)$tipoLn == CNAB240Processor::TRAILER_LOTE) {
            $vlinha = $this->processarTrailerLote($linha);
        } else if ((string)$tipoLn == CNAB240Processor::TRAILER_ARQUIVO) {
            $vlinha = $this->processarTrailerArquivo($linha);
        }

        return $vlinha;
    }

    public function processCnab(RetornoInterface $retorno, ComposableInterface $composable, LoteInterface $lote = null)
    {
        switch ((int)$composable->getRegistro()->__toString()) {
            case AbstractCNAB400Processor::HEADER_ARQUIVO:
                $retorno->setHeader($composable);
                break;

            case self::TRAILER_ARQUIVO:
                $retorno->setTrailer($composable);
                break;

            case self::HEADER_LOTE:
                if ($composable instanceof CnabHeaderInterface) {
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
