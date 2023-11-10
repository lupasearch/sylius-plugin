<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\LupaExportableIds;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIdsInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @extends ObjectRepository<LupaExportableIdsInterface>
 */
interface LupaExportableIdsRepositoryInterface extends ObjectRepository
{
    /**
     * @param int[] $ids
     *
     * @return int[]
     */
    public function findIdsThatAreNotAlreadyThere(array $ids, string $column): array;

    /**
     * @return LupaExportableIdsInterface[]
     */
    public function findAllInBatches(int $limit, int $offset): array;

    /**
     * @param int[] $ids
     */
    public function deleteByIds(array $ids): void;
}
