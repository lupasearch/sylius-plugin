<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\LupaExportableIds;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIdsInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<LupaExportableIdsInterface>
 */
class LupaExportableIdsRepository extends ServiceEntityRepository implements LupaExportableIdsRepositoryInterface
{
    public function findIdsThatAreNotAlreadyThere(array $ids, string $column): array
    {
        $idsThatAreAlreadyThere = $this->createQueryBuilder('lupa_exportable_ids')
            ->select('lupa_exportable_ids.' . $column)
            ->where('lupa_exportable_ids.' . $column . ' IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getSingleColumnResult();

        return array_diff($ids, $idsThatAreAlreadyThere);
    }

    public function findAllInBatches(int $limit, int $offset): array
    {
        /** @var LupaExportableIdsInterface[] */
        return $this->createQueryBuilder('lupa_exportable_ids')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function deleteByIds(array $ids): void
    {
        $query = $this->createQueryBuilder('lupa_exportable_ids')
            ->delete($this->getEntityName(), 'lupa_exportable_ids')
            ->where('lupa_exportable_ids.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery();

        $query->execute();
    }
}
