<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\Processor;

use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\DetailConvenio;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\HeaderConvenio;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;
use Umbrella\Ya\RetornoBoleto\Exception\EmptyLineException;
use Umbrella\Ya\RetornoBoleto\Exception\InvalidPositionException;

/**
 * Classe para leitura de arquivos de retorno de cobranças no padrão CNAB400/CBR643 com convênio de 7 posições.<br/>
 * Layout Padrão CNAB/Febraban 400 posições<br/>.
 * Baseado na documentação para "Layout de Arquivo Retorno para convênios na faixa numérica entre 1.000.000 a 9.999.999
 * (Convênios de 7 posições). Versão Set/09" do Banco do Brasil (arquivo Doc8826BR643Pos6.pdf),
 * disponível em http://www.bb.com.br/docs/pub/emp/empl/dwn/Doc8826BR643Pos6.pdf
 * @copyright GPLv2
 * @package ArquivoRetornoTitulosBancarios
 * @author Manoel Campos da Silva Filho. http://manoelcampos.com/contato
 * @version 0.4
 */
class CNAB400Conv6Processor extends AbstractCNAB400Processor
{
    /**
     * @property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE 
     */
    const DETALHE = 1;

    public function createHeader()
    {
        return new HeaderConvenio();
    }

    public function createDetail()
    {
        return new DetailConvenio();
    }

    /**
     * Processa a linha header do arquivo
     * @param string $linha Linha do header de arquivo processado
     * @return string Retorna um vetor contendo os dados dos campos do header do arquivo. 
     */
    protected function processarHeaderArquivo($linha)
    {
        $header = parent::processarHeaderArquivo($linha);
        $header->setConvenio(substr($linha, 41, 6))
            ->setSequencialRet(substr($linha, 101, 7))
            ->addComplemento(substr($linha, 108, 287));

        return $header;
    }

    /**
     * Processa uma linha detalhe do arquivo.
     * @param string $linha Linha detalhe do arquivo processado
     * @return string Retorna um vetor contendo os dados dos campos da linha detalhe. 
     */
    protected function processarDetalhe($linha)
    {
        $detail = parent::processarDetalhe($linha);
        $detail
            ->setConvenio(substr($linha, 32, 6))
            ->setControle(substr($linha, 38, 25))
            ->setNossoNumero(substr($linha, 63, 11))
            ->setDvNossoNumero(substr($linha, 74, 1))
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
        ;
        return $detail;
    }

    /**
     * Processa uma linha do arquivo de retorno.
     * @param int $numLn Número_linha a ser processada
     * @param string $linha String contendo a linha a ser processada
     * @return IComposable Retorna um vetor associativo contendo os valores_linha processada. 
     */
    public function processarLinha($numLn, $linha)
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
        $linha = " $linha";
        $tipoLn = substr($linha, 1, 1);
        if ($tipoLn == self::HEADER_ARQUIVO) {
            $vlinha = $this->processarHeaderArquivo($linha);
        } else if ($tipoLn == self::DETALHE) {
            $vlinha = $this->processarDetalhe($linha);
        } else if ($tipoLn == self::TRAILER_ARQUIVO) {
            $vlinha = $this->processarTrailerArquivo($linha);
        } else {
            $vlinha = null;
        }
        return $vlinha;
    }
}