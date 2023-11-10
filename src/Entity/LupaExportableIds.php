<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Entity;

class LupaExportableIds implements LupaExportableIdsInterface
{
    private ?int $id = null;

    private ?int $productVariantToAddId = null;

    private ?int $productVariantToRemoveId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductVariantToAddId(): ?int
    {
        return $this->productVariantToAddId;
    }

    public function setProductVariantToAddId(?int $productVariantToAddId): self
    {
        $this->productVariantToAddId = $productVariantToAddId;

        return $this;
    }

    public function getProductVariantToRemoveId(): ?int
    {
        return $this->productVariantToRemoveId;
    }

    public function setProductVariantToRemoveId(?int $productVariantToRemoveId): self
    {
        $this->productVariantToRemoveId = $productVariantToRemoveId;

        return $this;
    }
}
