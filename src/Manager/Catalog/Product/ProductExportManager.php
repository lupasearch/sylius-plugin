<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Product;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\ProductInterface;

/**
 * @implements LupaExportManagerInterface<ProductInterface>
 */
class ProductExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductInterface;
    }

    public function export(object $object): void
    {
        if (false === $object->isEnabled()) {
            $this->delete($object);

            return;
        }

        $variants = $object->getVariants();
        foreach ($variants as $variant) {
            if (null === $variant->getId()) {
                $this->logger->warning(
                    'Product variant has no id',
                );

                continue;
            }

            $this->lupaContext->addProductVariantIdToAdd($variant->getId());
        }
    }

    public function delete(object $object): void
    {
        $variants = $object->getVariants();
        foreach ($variants as $variant) {
            if (null === $variant->getId()) {
                $this->logger->warning(
                    'Product variant has no id',
                );

                continue;
            }

            $this->lupaContext->addProductVariantIdToRemove($variant->getId());
        }
    }
}
