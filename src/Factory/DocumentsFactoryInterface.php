<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<DocumentsInterface>
 */
interface DocumentsFactoryInterface extends FactoryInterface
{
    public function createNew(): DocumentsInterface;

    /**
     * @param DocumentInterface[] $documentArray
     */
    public function createFromDocumentArray(array $documentArray): DocumentsInterface;
}
