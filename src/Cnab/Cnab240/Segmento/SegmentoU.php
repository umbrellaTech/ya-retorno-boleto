<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\DadosTitulo;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Detail;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Ocorrencia;
use Umbrella\Ya\RetornoBoleto\Model\Sacado;

class SegmentoU extends AbstractSegmento
{

    public function buildDetail(Stringy $linha)
    {
        $detail = new Detail();
        $banco = new Banco();
        $bancoSacado = new Banco();
        $sacado = new Sacado();
        $ocorrencia = new Ocorrencia();
        $dadosTitulo = new DadosTitulo();
        $cedente = new Cedente();

        $bancoSacado->setCod($linha->substr(1, 3));
        $sacado->setBanco($bancoSacado);

        $detail
            ->setLote($linha->substr(4, 4))
            ->setRegistro($linha->substr(8, 1))
            ->setNumRegistroLote($linha->substr(9, 5))
            ->setSegmento($linha->substr(14, 1))
            ->addCnab($linha->substr(15, 1))
            ->setCodMovimento($linha->substr(16, 2));

        //Dados do Titulo
        $dadosTitulo->setAcrescimos($this->convertToFloat($linha->substr(18, 15)))
            ->setValorDesconto($this->convertToFloat($linha->substr(33, 15)))
            ->setValorAbatimento($this->convertToFloat($linha->substr(48, 15)))
            ->setValorIOF($this->convertToFloat($linha->substr(63, 15)))
            ->setValorPago($this->convertToFloat($linha->substr(78, 15)))
            ->setValorLiquido($this->convertToFloat($linha->substr(93, 15)));

        $detail->setDadosTitulo($dadosTitulo)
            ->setOutrasDespesas($this->convertToFloat($linha->substr(108, 15)))
            ->setOutrosCreditos($this->convertToFloat($linha->substr(123, 15)))
            ->setDataOcorrencia($this->createDate($linha->substr(138, 8), "dmY"))
            ->setDataCredito($this->createDate($linha->substr(146, 8), "dmY"));

        $ocorrencia->setCod(($this->convertToInt($linha->substr(154, 4))))
            ->setData($this->createDate($linha->substr(158, 8)))
            ->setValor($this->convertToFloat($linha->substr(166, 15)))
            ->setComplemento($linha->substr(181, 30));

        $banco->setCod($linha->substr(211, 3));
        $cedente->setBanco($banco);

        $detail->setNossoNumero($linha->substr(214, 20))
            ->addCnab($linha->substr(234, 7));

        $detail
            ->setCedente($cedente)
            ->setSacado($sacado);

        return $detail;
    }
}
