<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\BatchDeleteDocumentsInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<BatchDeleteDocumentsInterface>
 */
interface BatchDeleteDocumentsFactoryInterface extends FactoryInterface
{
    public function createNew(): BatchDeleteDocumentsInterface;

    /**
     * @param string[] $ids
     */
    public function createFromIds(array $ids): BatchDeleteDocumentsInterface;
}
