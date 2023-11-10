<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

use LupaSearch\SyliusLupaSearchPlugin\Enum\FacetType;

class Facet implements FacetInterface
{
    private ?string $key = null;

    private ?FacetType $type = null;

    private ?string $label = null;

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getType(): ?FacetType
    {
        return $this->type;
    }

    public function setType(?FacetType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
