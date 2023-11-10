<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

use LupaSearch\SyliusLupaSearchPlugin\Enum\FacetType;

interface FacetInterface
{
    public function getKey(): ?string;

    public function setKey(?string $key): Facet;

    public function getType(): ?FacetType;

    public function setType(?FacetType $type): Facet;

    public function getLabel(): ?string;

    public function setLabel(?string $label): Facet;
}
