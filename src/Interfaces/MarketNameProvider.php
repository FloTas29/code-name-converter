<?php

namespace Cordon\CodeNameConverterBundle\Interfaces;

interface MarketNameProvider
{
    public function getMarketName(string $constructorCode, string $modelCode);
}