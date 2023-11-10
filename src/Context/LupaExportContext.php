<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Context;

class LupaExportContext implements LupaExportContextInterface
{
    /** @var array<int, bool> */
    private array $productVariantIdsToAdd = [];

    /** @var array<int, bool> */
    private array $productVariantIdsToRemove = [];

    private bool $queueForExport = true;

    public function addProductVariantIdToAdd(int $productVariantId): void
    {
        $this->productVariantIdsToAdd[$productVariantId] = false;
    }

    public function getProductVariantIdsToAdd(): array
    {
        return array_keys($this->productVariantIdsToAdd);
    }

    public function addProductVariantIdToRemove(int $productVariantId): void
    {
        $this->productVariantIdsToRemove[$productVariantId] = false;
    }

    public function getProductVariantIdsToRemove(): array
    {
        return array_keys($this->productVariantIdsToRemove);
    }

    public function clearProductVariantIdsToAdd(): void
    {
        $this->productVariantIdsToAdd = [];
    }

    public function clearProductVariantIdsToRemove(): void
    {
        $this->productVariantIdsToRemove = [];
    }

    public function setQueueForExport(bool $queueForExport): void
    {
        $this->queueForExport = $queueForExport;
    }

    public function isQueueForExport(): bool
    {
        return $this->queueForExport;
    }
}
