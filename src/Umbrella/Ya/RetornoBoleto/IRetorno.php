<?php

namespace Umbrella\Ya\RetornoBoleto;

interface IRetorno
{

    public function getHeader();

    public function getDetails();

    public function getTrailer();

    public function addDetail(IDetail $detail);

    public function removeDetail(IDetail $detail);
}