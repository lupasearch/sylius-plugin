<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface LupaExportableIdsInterface extends ResourceInterface
{
    public function getProductVariantToAddId(): ?int;

    public function setProductVariantToAddId(?int $productVariantToAddId): LupaExportableIds;

    public function getProductVariantToRemoveId(): ?int;

    public function setProductVariantToRemoveId(?int $productVariantToRemoveId): LupaExportableIds;
}
