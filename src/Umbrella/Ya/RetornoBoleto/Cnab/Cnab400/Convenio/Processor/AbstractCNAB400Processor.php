<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor;

use InvalidArgumentException;
use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Detail;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Header;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\ITrailer;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Trailer;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;
use Umbrella\Ya\RetornoBoleto\ILote;
use Umbrella\Ya\RetornoBoleto\IRetorno;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Cobranca;

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
        $header->setRegistro(substr($linha, 1, 1));
        $header->setTipoOperacao(substr($linha, 2, 1));
        $header->setIdTipoOperacao(substr($linha, 3, 7));
        $header->setIdTipoServico(substr($linha, 10, 2));
        $header->setTipoServico(substr($linha, 12, 8));
        $header->addComplemento(substr($linha, 20, 7));

        $bancoArray = array();
        if (!preg_match('#^([\d]{3})(.+)#', substr($linha, 77, 18), $bancoArray)) {
            throw new InvalidArgumentException('Banco invalido');
        }

        $banco = new Banco();
        $banco
            ->setCod($bancoArray[1])
            ->setNome($bancoArray[2])
            ->setAgencia(substr($linha, 27, 4))
            ->setDvAgencia(substr($linha, 31, 1))
            ->setConta(substr($linha, 32, 8))
            ->setDvConta(substr($linha, 40, 1));


        $cedente = new Cedente();
        $cedente->setBanco($banco)
            ->setNome(substr($linha, 47, 30));

        $header->setCedente($cedente);
        $header->setDataGravacao($this->createDate(substr($linha, 95, 6)));
        $header->setSequencialReg(substr($linha, 395, 6));

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
            ->setAgencia(substr($linha, 22, 1))
            ->setDvAgencia(substr($linha, 31, 1))
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
            ->setTaxaDesconto($this->formataNumero(substr($linha, 96, 5)))
            ->setTaxaIof(substr($linha, 101, 5))
            ->setCateira(substr($linha, 107, 2))
            ->setComando(substr($linha, 109, 2))
            ->setDataOcorrencia($this->createDate(substr($linha, 111, 6)))
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
            ->setCanalPagTitulo(substr($linha, 393, 2))
            ->setSequencial(substr($linha, 395, 6))
        ;

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
            ->setSimples($simples)
            ->setVinculada($vinculada)
            ->setCaucionada($caucionada)
            ->setDescontada($descontada)
            ->setVendor($vendor)
            ->setSequencial(substr($linha, 395, 6))
        ;
        return $trailer;
    }

    public function processCnab(IRetorno $retorno, IComposable $composable,
                                ILote $lote = null)
    {
        switch ((int) $composable->getRegistro()) {
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
}