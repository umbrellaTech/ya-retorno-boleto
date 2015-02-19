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
            ->setRegistro($linha->substr(8, 1)->trim())
            ->setLote($linha->substr(4, 4)->trim())
            ->addCnab($linha->substr(9, 9)->trim())
            ->addCnab($linha->substr(133, 10)->trim())
            ->addCnab($linha->substr(212, 29)->trim())
            ->setConvenio($linha->substr(33, 20)->trim())
            ->setCodArquivo($linha->substr(143, 1)->trim());

        $header->setDataGeracao($this->createDateTime($linha->substr(144, 8)->trim() . " " . $linha->substr(152, 6)->trim()))
            ->setSequencialRet($linha->substr(158, 6)->trim())
            ->setVersaoLayout($linha->substr(164, 3)->trim())
            ->setDensidade($linha->substr(167, 5)->trim());

        $empresa = new Empresa();
        $empresa
            ->setTipoInscricao($linha->substr(18, 1)->trim())
            ->setNumInscricao($linha->substr(19, 14)->trim())
            ->setNome($linha->substr(73, 30)->trim())
            ->addReservado($linha->substr(192, 20)->trim());

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3)->trim())
            ->setNome($linha->substr(103, 30)->trim())
            ->setAgencia($linha->substr(53, 5)->trim())
            ->setDvAgencia($linha->substr(58, 1)->trim())
            ->setConta($linha->substr(59, 12)->trim())
            ->setDvConta($linha->substr(71, 1)->trim())
            ->setDvAgenciaConta($linha->substr(72, 1)->trim())
            ->addReservado($linha->substr(172, 20)->trim());


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
            ->setRegistro($linha->substr(8, 1)->trim())
            ->setLote($linha->substr(4, 4)->trim())
            ->setOperacao($linha->substr(9, 1)->trim())
            ->setServico($linha->substr(10, 2)->trim())
            ->setFormaLancamento($linha->substr(12, 2)->trim())
            ->setVersaoLayout($linha->substr(14, 3)->trim())
            ->addCnab($linha->substr(17, 1)->trim())
            ->addCnab($linha->substr(223, 8)->trim())
            ->addOcorrencia($linha->substr(231, 10)->trim())
            ->setConvenio($linha->substr(33, 20)->trim())
            ->addMensagem($linha->substr(103, 40)->trim());

        $endereco = new Endereco();
        $endereco
            ->setLogradourdo($linha->substr(143, 30)->trim())
            ->setNumero($linha->substr(173, 5)->trim())
            ->setComplemento($linha->substr(178, 15)->trim())
            ->setCidade($linha->substr(193, 20)->trim())
            ->setCep($linha->substr(213, 5)->trim())
            ->setComplementoCep($linha->substr(218, 3)->trim())
            ->setEstado($linha->substr(221, 2)->trim());
        $empresa = new Empresa();
        $empresa
            ->setEndereco($endereco)
            ->setTipoInscricao($linha->substr(18, 1)->trim())
            ->setNumInscricao($linha->substr(19, 14)->trim())
            ->setNome($linha->substr(73, 30)->trim());

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3)->trim())
            ->setNome($linha->substr(103, 30)->trim())
            ->setAgencia($linha->substr(53, 5)->trim())
            ->setDvAgencia($linha->substr(58, 1)->trim())
            ->setConta($linha->substr(59, 12)->trim())
            ->setDvConta($linha->substr(71, 1)->trim())
            ->setDvAgenciaConta($linha->substr(72, 1)->trim());


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
        $segmento = $linha->substr(14, 1)->trim();
        return $factory->getDetail($segmento)->buildDetail($linha);
    }

    protected function processarTrailerLote($linha)
    {
        $trailer = new TrailerLote();

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3)->trim());

        $cedente = new Cedente();
        $cedente
            ->setNome($linha->substr(62, 30)->trim())
            ->setBanco($banco);

        $trailer
            ->setLote($linha->substr(4, 4)->trim())
            ->setRegistro($linha->substr(8, 1)->trim())
            ->addCnab($linha->substr(9, 9)->trim())
            ->setQuantidadeRegistros($linha->substr(18, 6)->trim())
            ->setValor($linha->substr(24, 16)->trim())
            ->setQuantidadeMoedas($linha->substr(42, 13)->trim())
            ->setNumAvisoDepbito($linha->substr(60, 6)->trim())
            ->addCnab($linha->substr(66, 165)->trim())
            ->addOcorrencia($linha->substr(231, 10)->trim());

        return $trailer;
    }

    protected function processarTrailerArquivo($linha)
    {
        $trailer = new Trailer();

        $banco = new Banco();
        $banco
            ->setCod($linha->substr(1, 3)->trim());

        $cedente = new Cedente();
        $cedente
            ->setNome($linha->substr(62, 30)->trim())
            ->setBanco($banco);

        $trailer
            ->setLote($linha->substr(4, 4)->trim())
            ->setRegistro($linha->substr(8, 1)->trim())
            ->addCnab($linha->substr(9, 9)->trim())
            ->setQuantidadeLotes($linha->substr(18, 6)->trim())
            ->setQuantidadeRegistros($linha->substr(24, 6)->trim())
            ->setQuantidadeContasConc($linha->substr(30, 6)->trim())
            ->addCnab($linha->substr(36, 205)->trim());

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
        $tipoLn = $linha->substr(8, 1)->trim();

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
