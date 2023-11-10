<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\Facet;
use LupaSearch\SyliusLupaSearchPlugin\Model\FacetInterface;

class FacetFactory implements FacetFactoryInterface
{
    public function createNew(): FacetInterface
    {
        return new Facet();
    }
}
