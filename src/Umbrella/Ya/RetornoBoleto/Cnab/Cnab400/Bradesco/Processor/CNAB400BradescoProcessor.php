<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Bradesco\Processor;

use Umbrella\Ya\RetornoBoleto\AbstractProcessor;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Bradesco\DetailBradesco;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Bradesco\HeaderBradesco;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\ITrailer;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Trailer;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;
use Umbrella\Ya\RetornoBoleto\ILote;
use Umbrella\Ya\RetornoBoleto\IRetorno;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Cobranca;
use Umbrella\Ya\RetornoBoleto\Model\Empresa;

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
class CNAB400BradescoProcessor extends AbstractProcessor
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
        return new HeaderBradesco();
    }

    public function createDetail()
    {
        return new DetailBradesco();
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
        $header->setRegistro(substr($linha, 1, 1))
            ->setTipoOperacao(substr($linha, 2, 1))
            ->setIdTipoOperacao(substr($linha, 3, 7))
            ->setIdTipoServico(substr($linha, 10, 2))
            ->setTipoServico(substr($linha, 12, 15));

        $empresa = new Empresa();
        $empresa->setCod(substr($linha, 27, 20))
            ->setNome(substr($linha, 47, 30));

        $banco = new Banco();
        $banco
            ->setCod(substr($linha, 77, 3))
            ->setNome(substr($linha, 80, 15));


        $cedente = new Cedente();
        $cedente->setBanco($banco)
            ->setNome(substr($linha, 47, 30));

        $header->setEmpresa($empresa)
            ->setCedente($cedente)
            ->setDataGravacao($this->createDate(substr($linha, 95, 6)))
            ->setDensidadeGravacao(substr($linha, 101, 8))
            ->setNumAvisoCredito(substr($linha, 109, 5))
            ->setSequencialReg(substr($linha, 395, 6));

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

        $bancoEmpresa = new Banco();
        $bancoEmpresa->setCod(substr($linha, 21, 17));
        $empresa = new Empresa();
        $empresa
            ->setBanco($bancoEmpresa)
            ->setTipoInscricao(substr($linha, 2, 2))
            ->setNumInscricao(substr($linha, 4, 14))
            ->addReservado(substr($linha, 38, 25));

        $detail
            ->setBancoEmissor($bancoEmissor)
            ->setBancoRecebedor($bancoRecebedor)
            ->setRegistro(substr($linha, 1, 1))
            ->setNumOcorrencia(substr($linha, 117, 10))
            ->setDataVencimento(substr($linha, 147, 6))
            ->setValor($this->formataNumero(substr($linha, 153, 13)))
            ->setDespCobranca(substr($linha, 176, 2))
            ->setOutrasDespesas($this->formataNumero(substr($linha, 189, 13)))
            ->setJurosAtraso($this->formataNumero(substr($linha, 202, 13)))
            ->setTaxaIof($this->formataNumero(substr($linha, 215, 13)))
            ->setDescontoConcedido($this->formataNumero(substr($linha, 241, 13)))
            ->setValorRecebido($this->formataNumero(substr($linha, 254, 13)))
            ->setJurosMora($this->formataNumero(substr($linha, 267, 13)))
            ->setOutrosRecebimentos($this->formataNumero(substr($linha, 280, 13)))
            ->setValorAbatimento($this->formataNumero(substr($linha, 228, 13)))
            ->setValorLancamento($this->formataNumero(substr($linha, 306, 13)))
            ->setIndicativoDc(substr($linha, 319, 1))
            ->setIndicadorValor(substr($linha, 320, 1))
            ->setValorAjuste($this->formataNumero(substr($linha, 321, 12)))
            ->setSequencial(substr($linha, 395, 6))
            ->setMotivoCodOcorrencia(substr($linha, 319, 10))
            ->setNumCartorio(substr($linha, 369, 2))
            ->setNumCartorio(substr($linha, 369, 2))
            ->setNumCartorio(substr($linha, 369, 2))
        ;

        return $detail;

        $vlinha["motivo_cod_ocorrencia"] = substr($linha, 319, 10);  //Motivos das Rejeições para 
        //os Códigos de Ocorrência da Posição 109 a 110 
        $vlinha["num_cartorio"] = substr($linha, 369, 2);
        $vlinha["num_protocolo"] = substr($linha, 371, 10);

        $vlinha["abatimento_nao_aprov"] = $this->formataNumero(substr($linha,
                                                                      293, 13)); //9  v99 Abatimento não aproveitado pelo sacado

        return $vlinha;
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

    public function processarLinha($numLn, $linha)
    {
        
    }
}