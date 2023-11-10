<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Product;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

/**
 * @implements LupaExportManagerInterface<ProductVariantInterface>
 */
class ProductVariantExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductVariantInterface;
    }

    public function export(object $object): void
    {
        if (null === $object->getId()) {
            $this->logger->warning(
                'Product variant has no id',
            );

            return;
        }

        $this->lupaContext->addProductVariantIdToAdd($object->getId());
    }

    public function delete(object $object): void
    {
        if (null === $object->getId()) {
            $this->logger->warning(
                'Product variant has no id',
            );

            return;
        }

        $this->lupaContext->addProductVariantIdToRemove($object->getId());
    }
}
