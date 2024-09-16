<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Product;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Product\Model\ProductVariantTranslationInterface;
use Webmozart\Assert\Assert;

/**
 * @implements LupaExportManagerInterface<ProductVariantTranslationInterface>
 */
class ProductVariantTranslationExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductVariantTranslationInterface;
    }

    public function export(object $object): void
    {
        $productVariant = $object->getTranslatable();
        if (false === $productVariant->isEnabled()) {
            $this->delete($object);

            return;
        }

        Assert::isInstanceOf($productVariant, ProductVariantInterface::class);
        if (null === $productVariant->getId()) {
            $this->logger->warning(
                'Product variant translation has no id',
            );

            return;
        }

        $this->lupaContext->addProductVariantIdToAdd($productVariant->getId());
    }

    public function delete(object $object): void
    {
        $productVariant = $object->getTranslatable();
        Assert::isInstanceOf($productVariant, ProductVariantInterface::class);
        if (null === $productVariant->getId()) {
            $this->logger->warning(
                'Product variant translation has no id',
            );

            return;
        }

        $this->lupaContext->addProductVariantIdToRemove($productVariant->getId());
    }
}
