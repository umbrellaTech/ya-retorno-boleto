<?php

namespace Umbrella\Ya\RetornoBoleto;

use DateTime;
use Umbrella\Ya\RetornoBoleto\Cnab\IComposable;

/**
 * Classe base para leitura de arquivos de retorno de cobranças dos bancos brasileiros.<br/>
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
abstract class AbstractProcessor
{
    /**
     * @property string $nomeArquivo Nome do arquivo de texto a ser lido 
     */
    protected $nomeArquivo = "";

    /**
     * @property string $aoProcessarLinha Armazena o nome da função handler 
     * que será chamada após o processamento de cada linha do arquivo, com
     * isto, definindo um evento aoProcessarLinha.	 
     */
    protected $aoProcessarLinha = "";
    protected $needToCreateLote = false;

    /**
     * Construtor da classe.
     * @param string $nomeArquivo Nome do arquivo de retorno do banco.
     * @param string $aoProcessarLinhaFunctionName Nome da função handler a ser associada
     * ao evento aoProcessarLinha. Se for informado um valor ao parâmetro, a função, indicada por ele, 
     * será executada após cada linha ser processada no arquivo de retorno.
     */
    public function __construct($nomeArquivo = null,
                                $aoProcessarLinhaFunctionName = null)
    {
        if (isset($nomeArquivo)) {
            $this->setNomeArquivo($nomeArquivo);
        }

        $this->setAoProcessarLinha($aoProcessarLinhaFunctionName);
    }

    public function needToCreateLote()
    {
        return $this->needToCreateLote;
    }

    public function setNeedToCreateLote($needToCreateLote)
    {
        $this->needToCreateLote = $needToCreateLote;
        return $this;
    }

    /**
     * Setter para o atributo
     * @param string $nomeArquivo
     */
    public function setNomeArquivo($nomeArquivo)
    {
        $this->nomeArquivo = $nomeArquivo;
    }

    /**
     * Getter para o atributo
     */
    public function getNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    /**
     * Processa uma linha do arquivo de retorno. O método é abstrato e deve ser implementado nas sub-classes.
     * @param int $numLn Número da linha a ser processada
     * @param string $linha String contendo a linha a ser processada
     * @return IComposable Retorna um vetor associativo contendo os valores da linha processada.
     */
    public abstract function processarLinha($numLn, $linha);

    public abstract function processCnab(IRetorno $retorno,
                                         IComposable $composable,
                                         ILote $lote = null);

    /**
     * Atribui uma função ao evento aoProcessarLinha.
     * @param string $handlerFunctionName String contendo o nome da função handler,
     * definida pelo usuário fora da classe, que será executada quando o evento aoProcessarLinha for disparado.
     * Esta função deve ter a assinatura funcao($numLn, $vlinha), onde
     * $numLn recebe o número da linha processada e $vlinha recebe um vetor associativo
     * contendos os valores da linha.
     * Nela o usuário pode fazer o que desejar com os parâmetro recebidos ($numLn e $vlinha),
     * como setar um campo em uma tabela do banco de dados, para indicar
     * o pagamento de um boleto de um determinado cliente.
     */
    public function setAoProcessarLinha($handlerFunctionName)
    {
        $this->aoProcessarLinha = $handlerFunctionName;
    }

    /**
     * Se existe uma função handler associadao ao evento aoProcessarLinha,
     * executa a mesma, disparando o evento.
     * @param AbstractProcessor $self
     * @param int $lineNumber Número da linha processada.
     * @param IComposable $composable IComposable contendo a linha processada, contendo os valores da armazenados
     * nas colunas deste vetor. Nesta função o usuário pode fazer o que desejar,
     * como setar um campo em uma tabela do banco de dados, para indicar
     * o pagamento de um boleto de um determinado cliente.
     */
    public function triggerAoProcessarLinha($self, $lineNumber, $composable)
    {
        //Obtém o nome da função handler associada ao evento aoProcessarLinha
        $funcName = $this->aoProcessarLinha;

        if ($this->aoProcessarLinha) {
            return call_user_func($funcName, $self, $lineNumber, $composable);
        }
    }

    /**
     * Formata uma string, contendo um valor real (float) sem o separador de decimais,
     * para a sua correta representação real.
     * @param string $valor String contendo o valor na representação
     * usada nos arquivos de retorno do banco, sem o separador de decimais.
     * @param int $numCasasDecimais Total de casas decimais do número
     * representado em $valor.
     * @return float Retorna o número representado em $valor, no seu formato float,
     * contendo o separador de decimais. 
     */
    public function formataNumero($valor, $numCasasDecimais = 2)
    {
        if (empty($valor)) {
            return 0;
        }
        $casas = $numCasasDecimais;
        if ($casas > 0) {
            $valor = substr($valor, 0, strlen($valor) - $casas) . "." . substr($valor,
                                                                               strlen($valor) - $casas,
                                                                                      $casas);
            $valor = (float) $valor;
        } else {
            $valor = (int) $valor;
        }

        return $valor;
    }

    /**
     * Formata uma string, contendo uma data sem o separador, no formato DDMMAA.
     * @param string $date String contendo a data no formato DDMMAA.
     * @return DateTime
     */
    public function createDate($date, $format = "mdy")
    {
        if (empty($date)) {
            return "";
        }

        return DateTime::createFromFormat($format, $date);
    }

    /**
     * Formata uma string, contendo uma data sem o separador, no formato DDMMAA HHIISS.
     * @param string $dateTimeString String contendo a data no formato DDMMAA.
     * @return DateTime 
     */
    public function createDateTime($dateTimeString, $format = "mdy His")
    {
        if (empty($dateTimeString)) {
            return "";
        }

        return DateTime::createFromFormat($format, $dateTimeString);
    }
}