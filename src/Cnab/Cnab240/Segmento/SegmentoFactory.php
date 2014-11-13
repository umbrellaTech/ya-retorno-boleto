<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

/**
 * Classe que identifica o tipo de arquivo de retorno sendo carregado e instancia a classe
 * específica para leitura do mesmo.
 * @author Ítalo Lelis de Vietro <italolelis@gmail.com>
 */
class SegmentoFactory
{
    /**
     * @param string $tipo O tipo do segmento para carregar os detalhes
     * @return SegmentoInterface
     */
    public function getDetail($tipo)
    {
        $reflection = new \ReflectionClass('\Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento\Segmento' . strtoupper($tipo));
        return $reflection->newInstanceArgs();
    }
}
