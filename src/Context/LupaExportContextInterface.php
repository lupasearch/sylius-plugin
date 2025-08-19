<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Context;

interface LupaExportContextInterface
{
    public function addIdToAdd(int $id): void;

    /**
     * @return int[]
     */
    public function getIdsToAdd(): array;

    public function addIdToRemove(int $id): void;

    /**
     * @return int[]
     */
    public function getIdsToRemove(): array;

    public function clearIdsToAdd(): void;

    public function clearIdsToRemove(): void;

    public function setQueueForExport(bool $queueForExport): void;

    public function isQueueForExport(): bool;
}
