<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor;

use InvalidArgumentException;
use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Detail;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Header;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\ITrailer;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Trailer;
use Umbrella\Ya\RetornoBoleto\Cnab\ComposableInterface;
use Umbrella\Ya\RetornoBoleto\Exception\EmptyLineException;
use Umbrella\Ya\RetornoBoleto\Exception\InvalidPositionException;
use Umbrella\Ya\RetornoBoleto\LoteInterface;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Cobranca;
use Umbrella\Ya\RetornoBoleto\RetornoInterface;

/**
 * Classe abstrata para leitura de arquivos de retorno de cobranças no padrão CNAB400/CBR643.<br/>
 * Layout Padrão CNAB/Febraban 400 posições<br/>.
 * Baseado na documentação para "Layout de Arquivo Retorno para Convênios
 * na faixa numérica entre 000.001 a 999.999 (Convênios de até 6 posições). Versão Set/09" e
 * "Layout de Arquivo Retorno para convênios na faixa numérica entre 1.000.000 a 9.999.999
 * (Convênios de 7 posições). Versão Set/09" do Banco do Brasil
 * (arquivos Doc8826BR643Pos6.pdf e Doc2628CBR643Pos7.pdf)
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
abstract class AbstractCNAB400Processor extends AbstractProcessor
{
    /**
     * @property int HEADER_ARQUIVO Define o valor que identifica uma coluna do tipo HEADER DE ARQUIVO
     */
    const HEADER_ARQUIVO = 0;

    /**
     * @property int TRAILER_ARQUIVO Define o valor que identifica uma coluna do tipo TRAILER DE ARQUIVO
     */
    const TRAILER_ARQUIVO = 9;

    public function createHeader()
    {
        return new Header();
    }

    public function createDetail()
    {
        return new Detail();
    }

    public function createTrailer()
    {
        return new Trailer();
    }

    /**
     * Processa a linha header do arquivo
     * @param string $linha Linha do header de arquivo processado
     * @return string Retorna um vetor contendo os dados dos campos do header do arquivo.
     */
    protected function processarHeaderArquivo($linha)
    {
        $header = $this->createHeader();
        //X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
        $header->setRegistro($linha->substr(1, 1)->trim());
        $header->setTipoOperacao($linha->substr(2, 1)->trim());
        $header->setIdTipoOperacao($linha->substr(3, 7)->trim());
        $header->setIdTipoServico($linha->substr(10, 2)->trim());
        $header->setTipoServico($linha->substr(12, 8)->trim());
        $header->addComplemento($linha->substr(20, 7)->trim());

        $bancoArray = array();
        if (!preg_match('#^([\d]{3})(.+)#', $linha->substr(77, 18)->trim(), $bancoArray)) {
            throw new InvalidArgumentException('Banco invalido');
        }

        $banco = new Banco();
        $banco
            ->setCod($bancoArray[1])
            ->setNome($bancoArray[2])
            ->setAgencia($linha->substr(27, 4)->trim())
            ->setDvAgencia($linha->substr(31, 1)->trim())
            ->setConta($linha->substr(32, 8)->trim())
            ->setDvConta($linha->substr(40, 1)->trim());


        $cedente = new Cedente();
        $cedente->setBanco($banco)
            ->setNome($linha->substr(47, 30)->trim());

        $header->setCedente($cedente);
        $header->setDataGravacao($this->createDate($linha->substr(95, 6)->trim()));
        $header->setSequencialReg($linha->substr(395, 6)->trim());

        return $header;
    }

    /**
     * Processa uma linha detalhe do arquivo.
     * @param string $linha Linha detalhe do arquivo processado
     * @return string Retorna um vetor contendo os dados dos campos da linha detalhe.
     */
    protected function processarDetalhe($linha)
    {
        $detail = $this->createDetail();

        $bancoEmissor = new Banco();
        $bancoEmissor
            ->setAgencia($linha->substr(22, 1)->trim())
            ->setDvAgencia($linha->substr(31, 1)->trim())
            ->setConta($linha->substr(23, 8)->trim())
            ->setDvConta($linha->substr(31, 1)->trim());

        $bancoRecebedor = new Banco();
        $bancoRecebedor
            ->setCod($linha->substr(166, 3)->trim())
            ->setAgencia($linha->substr(169, 4)->trim())
            ->setDvAgencia($linha->substr(173, 1)->trim());

        $detail
            ->setBancoEmissor($bancoEmissor)
            ->setBancoRecebedor($bancoRecebedor)
            ->setRegistro($linha->substr(1, 1)->trim())
            ->setTaxaDesconto($this->formataNumero($linha->substr(96, 5)->trim()))
            ->setTaxaIof($linha->substr(101, 5)->trim())
            ->setCateira($linha->substr(107, 2)->trim())
            ->setComando($linha->substr(109, 2)->trim())
            ->setDataOcorrencia($this->createDate($linha->substr(111, 6)->trim()))
            ->setNumTitulo($linha->substr(117, 10)->trim())
            ->setDataVencimento($this->createDate($linha->substr(147, 6)->trim()))
            ->setValor($this->formataNumero($linha->substr(153, 13)->trim()))
            ->setEspecie($linha->substr(174, 2)->trim())
            ->setDataCredito($this->createDate($linha->substr(176, 6)->trim()))
            ->setValorTarifa($this->formataNumero($linha->substr(182, 7)->trim()))
            ->setOutrasDespesas($this->formataNumero($linha->substr(189, 13)->trim()))
            ->setJurosDesconto($this->formataNumero($linha->substr(202, 13)->trim()))
            ->setIofDesconto($this->formataNumero($linha->substr(215, 13)->trim()))
            ->setValorAbatimento($this->formataNumero($linha->substr(228, 13)->trim()))
            ->setDescontoConcedido($this->formataNumero($linha->substr(241, 13)->trim()))
            ->setValorRecebido($this->formataNumero($linha->substr(254, 13)->trim()))
            ->setJurosMora($this->formataNumero($linha->substr(267, 13)->trim()))
            ->setOutrosRecebimentos($this->formataNumero($linha->substr(280, 13)->trim()))
            ->setAbatimentoNaoAprovado($this->formataNumero($linha->substr(293, 13)->trim()))
            ->setValorLancamento($this->formataNumero($linha->substr(306, 13)->trim()))
            ->setIndicativoDc($linha->substr(319, 1)->trim())
            ->setIndicadorValor($linha->substr(320, 1)->trim())
            ->setValorAjuste($this->formataNumero($linha->substr(321, 12)->trim()))
            ->setCanalPagTitulo($linha->substr(393, 2)->trim())
            ->setSequencial($linha->substr(395, 6)->trim());

        return $detail;
    }

    /**
     * Processa a linha trailer do arquivo.
     * @param string $linha Linha trailer do arquivo processado
     * @return ITrailer Retorna um vetor contendo os dados dos campos da linha trailer do arquivo.
     */
    protected function processarTrailerArquivo($linha)
    {
        $trailer = $this->createTrailer();

        $banco = new Banco();
        $banco->setCod($linha->substr(5, 3)->trim());

        $simples = new Cobranca();
        $simples->setQtdTitulos($linha->substr(18, 8)->trim())
            ->setValorTotal($this->formataNumero($linha->substr(26, 14)->trim()))
            ->setNumAviso($linha->substr(40, 8)->trim());

        $vinculada = new Cobranca();
        $vinculada->setQtdTitulos($linha->substr(58, 8)->trim())
            ->setValorTotal($this->formataNumero($linha->substr(66, 14)->trim()))
            ->setNumAviso($linha->substr(80, 8)->trim());

        $caucionada = new Cobranca();
        $caucionada->setQtdTitulos($linha->substr(98, 8)->trim())
            ->setValorTotal($this->formataNumero($linha->substr(106, 14)->trim()))
            ->setNumAviso($linha->substr(120, 8)->trim());

        $descontada = new Cobranca();
        $descontada->setQtdTitulos($linha->substr(138, 8)->trim())
            ->setValorTotal($this->formataNumero($linha->substr(146, 14)->trim()))
            ->setNumAviso($linha->substr(160, 8)->trim());

        $vendor = new Cobranca();
        $vendor->setQtdTitulos($linha->substr(218, 8)->trim())
            ->setValorTotal($this->formataNumero($linha->substr(226, 14)->trim()))
            ->setNumAviso($linha->substr(240, 8)->trim());

        $trailer
            ->setBanco($banco)
            ->setRegistro($linha->substr(1, 1)->trim())
            ->setRetorno($linha->substr(2, 1)->trim())
            ->setTipoRegistro($linha->substr(3, 2)->trim())
            ->setSimples($simples)
            ->setVinculada($vinculada)
            ->setCaucionada($caucionada)
            ->setDescontada($descontada)
            ->setVendor($vendor)
            ->setSequencial($linha->substr(395, 6)->trim());
        return $trailer;
    }

    public function processCnab(RetornoInterface $retorno, ComposableInterface $composable, LoteInterface $lote = null)
    {
        switch ((int)$composable->getRegistro()->__toString()) {
            case self::HEADER_ARQUIVO:
                $retorno->setHeader($composable);
                break;

            case self::TRAILER_ARQUIVO:
                $retorno->setTrailer($composable);
                break;

            default:
                $lote->addDetail($composable);
                break;
        }
    }

    /**
     * Processa uma linha do arquivo de retorno.
     * @param int $numLn Número_linha a ser processada
     * @param string $linha String contendo a linha a ser processada
     * @return IComposable Retorna um vetor associativo contendo os valores_linha processada.
     */
    public function processarLinha($numLn, Stringy $linha)
    {
        $tamLinha = 400; //total de caracteres das linhas do arquivo
        //o +2 é utilizado para contar o \r\n no final da linha
        if (strlen($linha) != $tamLinha && strlen($linha) != $tamLinha + 2) {
            throw new InvalidPositionException("A linha $numLn não tem $tamLinha posições. Possui " . strlen($linha));
        }

        if (trim($linha) == "") {
            throw new EmptyLineException("A linha $numLn está vazia.");
        }

        //é adicionado um espaço vazio no início_linha para que
        //possamos trabalhar com índices iniciando_1, no lugar_zero,
        //e assim, ter os valores_posição_campos exatamente
        //como no manual CNAB400
        $linha = $linha->insert(" ", 0);
        $tipoLn = $linha->substr(1, 1)->trim();

        $this->needToCreateLote = false;
        if ((string)$tipoLn == static::HEADER_ARQUIVO) {
            $this->needToCreateLote = true;
            $vlinha = $this->processarHeaderArquivo($linha);
        } elseif ((string)$tipoLn == static::DETALHE) {
            $vlinha = $this->processarDetalhe($linha);
        } elseif ((string)$tipoLn == static::TRAILER_ARQUIVO) {
            $vlinha = $this->processarTrailerArquivo($linha);
        } else {
            $vlinha = null;
        }
        return $vlinha;
    }
}
