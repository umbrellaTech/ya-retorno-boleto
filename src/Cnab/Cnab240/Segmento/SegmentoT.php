<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Detail;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;
use Umbrella\Ya\RetornoBoleto\Model\Empresa;
use Umbrella\Ya\RetornoBoleto\Model\Inscricao;
use Umbrella\Ya\RetornoBoleto\Model\Sacado;

class SegmentoT extends AbstractSegmento
{

    public function buildDetail(Stringy $linha)
    {
        $detail = new Detail();

        $banco = new Banco();
        $banco->setCod($linha->substr(1, 3));

        $detail
            ->setLote($linha->substr(4, 4))
            ->setRegistro($linha->substr(8, 1))
            ->setNumRegistroLote($linha->substr(9, 5))
            ->setSegmento($linha->substr(14, 1))
            ->setTipoMovimento($linha->substr(15, 1))
            ->setCodMovimento($linha->substr(16, 2));

        $banco->setAgencia($linha->substr(18, 5))
            ->setDvAgencia($linha->substr(23, 1))
            ->setConta($linha->substr(24, 12))
            ->setDvConta($linha->substr(36, 1));

        $detail->setNossoNumero($linha->substr(38, 20))
            ->setCarteira($linha->substr(58, 1))
            ->setNumeroDocumento($linha->substr(59, 15))
            ->setDataVencimento($linha->substr(74, 8))
            ->setValorTitulo($linha->substr(82, 13));

        $banco->setCod($linha->substr(97, 3))
            ->setAgencia($linha->substr(100, 5))
            ->setDvAgencia($linha->substr(105, 1));

        $empresa = new Empresa();
        $empresa->addUso($linha->substr(106, 25));

        $detail->setCodMoeda($linha->substr(131, 2));

        $sacado = new Sacado();
        $sacado->setInscricao(new Inscricao($linha->substr(134, 15), $linha->substr(133, 1)))
            ->setNome($linha->substr(149, 40));

        $detail->setNumeroContrato($linha->substr(189, 10))
            ->setValorTarifa($linha->substr(199, 13))
            ->addOcorrencia($linha->substr(214, 10))
            ->addCnab($linha->substr(224, 17));

        $cedente = new Cedente();
        $cedente->setBanco($banco);
        $detail
            ->setCedente($cedente)
            ->setSacado($sacado);

        return $detail;
    }
}
