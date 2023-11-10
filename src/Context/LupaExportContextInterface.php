<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Context;

interface LupaExportContextInterface
{
    public function addProductVariantIdToAdd(int $productVariantId): void;

    /**
     * @return int[]
     */
    public function getProductVariantIdsToAdd(): array;

    public function addProductVariantIdToRemove(int $productVariantId): void;

    /**
     * @return int[]
     */
    public function getProductVariantIdsToRemove(): array;

    public function clearProductVariantIdsToAdd(): void;

    public function clearProductVariantIdsToRemove(): void;

    public function setQueueForExport(bool $queueForExport): void;

    public function isQueueForExport(): bool;
}
