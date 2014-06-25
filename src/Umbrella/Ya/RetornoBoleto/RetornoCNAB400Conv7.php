<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Umbrella\Ya\RetornoBoleto;

use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\DetailConvenio;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab400\Convenio\HeaderConvenio;
use Umbrella\Ya\RetornoBoleto\Exception\EmptyLineException;
use Umbrella\Ya\RetornoBoleto\Exception\InvalidPositionException;

/**
 * Classe para leitura de arquivos de retorno de cobranças no padrão CNAB400/CBR643 com convênio de 7 posições.<br/>
 * Layout Padrão CNAB/Febraban 400 posições<br/>.
 * Baseado na documentação para "Layout de Arquivo Retorno para convênios na
 * faixa numérica entre 1.000.000 a 9.999.999 (Convênios de 7 posições). Versão Set/09"
 * do Banco do Brasil (arquivo Doc2628CBR643Pos7.pdf),
 * disponível em http://www.bb.com.br/docs/pub/emp/empl/dwn/Doc2628CBR643Pos7.pdf
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class RetornoCNAB400Conv7 extends AbstractRetornoCNAB400
{
    /**
     * @property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE 
     */
    const DETALHE = 7;

    public function __construct($nomeArquivo = NULL,
                                $aoProcessarLinhaFunctionName = "")
    {
        parent::__construct($nomeArquivo, $aoProcessarLinhaFunctionName);
    }

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
     * @return array<mixed> Retorna um vetor contendo os dados dos campos do header do arquivo. 
     */
    protected function processarHeaderArquivo($linha)
    {
        $header = parent::processarHeaderArquivo($linha);
        $header
            ->addComplemento(substr($linha, 108, 42))
            ->setConvenio(substr($linha, 150, 7))
            ->addComplemento(substr($linha, 108, 42))
        ;

        return $header;
    }

    /**
     * Processa uma linha detalhe do arquivo.
     * @param string $linha Linha detalhe do arquivo processado
     * @return array<mixed> Retorna um vetor contendo os dados dos campos da linha detalhe. 
     */
    protected function processarDetalhe($linha)
    {
        $detail = parent::processarDetalhe($linha);
        $detail
            ->setConvenio(substr($linha, 32, 7))
            ->setControle(substr($linha, 38, 25))
            ->setNossoNumero(substr($linha, 64, 17))
            ->setTipoCobranca(substr($linha, 81, 1))
            ->setTipoCobrancaCmd72(substr($linha, 82, 1))
            ->setDiasCalculo(substr($linha, 83, 4))
            ->setNatureza(substr($linha, 87, 2))
            ->setPrefixoTitulo(substr($linha, 89, 3))
            ->setVariacaoCarteira(substr($linha, 92, 3))
            ->setContaCaucao(substr($linha, 95, 1))
        ;
        return $detail;
    }

    /**
     * Processa uma linha do arquivo de retorno.
     * @param int $numLn Número_linha a ser processada
     * @param string $linha String contendo a linha a ser processada
     * @return array Retorna um vetor associativo contendo os valores_linha processada. 
     */
    public function processarLinha($numLn, $linha)
    {
        $tamLinha = 400; //total de caracteres das linhas do arquivo
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
        if ($tipoLn == RetornoCNAB400Conv7::HEADER_ARQUIVO) {
            $vlinha = $this->processarHeaderArquivo($linha);
        } else if ($tipoLn == RetornoCNAB400Conv7::DETALHE) {
            $vlinha = $this->processarDetalhe($linha);
        } else if ($tipoLn == RetornoCNAB400Conv7::TRAILER_ARQUIVO) {
            $vlinha = $this->processarTrailerArquivo($linha);
        } else {
            $vlinha = null;
        }
        return $vlinha;
    }
}