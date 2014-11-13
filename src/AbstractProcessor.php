<?php

namespace Umbrella\Ya\RetornoBoleto;

use DateTime;
use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\Cnab\ComposableInterface;

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
    protected $needToCreateLote = false;

    /**
     * Construtor da classe.
     * @param string $nomeArquivo Nome do arquivo de retorno do banco.
     */
    public function __construct($nomeArquivo = null)
    {
        if (isset($nomeArquivo)) {
            $this->setNomeArquivo($nomeArquivo);
        }
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
     * @return ComposableInterface Retorna um vetor associativo contendo os valores da linha processada.
     */
    public abstract function processarLinha($numLn, Stringy $linha);

    public abstract function processCnab(RetornoInterface $retorno, ComposableInterface $composable,
                                         LoteInterface $lote = null);

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
            $valor = substr($valor, 0, strlen($valor) - $casas) . "." . substr($valor, strlen($valor) - $casas, $casas);
            $valor = (float)$valor;
        } else {
            $valor = (int)$valor;
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
