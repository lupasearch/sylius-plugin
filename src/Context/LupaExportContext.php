<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Context;

class LupaExportContext implements LupaExportContextInterface
{
    /** @var array<int, bool> */
    private array $idsToAdd = [];

    /** @var array<int, bool> */
    private array $idsToRemove = [];

    private bool $queueForExport = true;

    public function addIdToAdd(int $id): void
    {
        $this->idsToAdd[$id] = false;
    }

    public function getIdsToAdd(): array
    {
        return array_keys($this->idsToAdd);
    }

    public function addIdToRemove(int $id): void
    {
        $this->idsToRemove[$id] = false;
    }

    public function getIdsToRemove(): array
    {
        return array_keys($this->idsToRemove);
    }

    public function clearIdsToAdd(): void
    {
        $this->idsToAdd = [];
    }

    public function clearIdsToRemove(): void
    {
        $this->idsToRemove = [];
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
