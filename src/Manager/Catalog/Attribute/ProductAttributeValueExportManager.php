<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Attribute;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Product\Model\ProductAttributeValueInterface;

/**
 * @implements LupaExportManagerInterface<ProductAttributeValueInterface>
 */
class ProductAttributeValueExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductAttributeValueInterface;
    }

    public function export(object $object): void
    {
        if (null === $object->getCode()) {
            $this->logger->warning(sprintf("Product attribute value with id %s has no code", $object->getId()));

            return;
        }

        $product = $object->getSubject();
        if (!$product) {
            $this->logger->warning(
                sprintf("Product attribute value with id %s has no associated product", $object->getId())
            );
            return;
        }

        $variants = $product->getVariants();
        if (!$variants) {
            $this->logger->warning(
                sprintf(
                    "Product with id %s has no variants for attribute value code %s",
                    $product->getId(),
                    $object->getCode()
                )
            );
            return;
        }

        $variantIds = $variants->map(fn($variant) => $variant->getId())->toArray();

        foreach ($variantIds as $variantId) {
            $this->lupaContext->addIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        /**
         * No action is required on delete for attribute values in this manager.
         * The attribute value logic is implemented in EventListener/ProductAttributeValueOnFlushListener.php
         * due to the absence of a product relation in this handler.
         */
    }
}
