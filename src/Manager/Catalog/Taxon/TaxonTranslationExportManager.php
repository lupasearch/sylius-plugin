<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Taxon;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Model\TaxonTranslationInterface;
use Webmozart\Assert\Assert;

/**
 * @implements LupaExportManagerInterface<TaxonTranslationInterface>
 */
class TaxonTranslationExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly ProductVariantRepositoryInterface $taxonRepository,
        private readonly LupaExportContextInterface $lupaContext,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof TaxonTranslationInterface;
    }

    public function export(object $object): void
    {
        $taxon = $object->getTranslatable();
        Assert::isInstanceOf($taxon, TaxonInterface::class);
        if (null === $taxon->getCode()) {
            $this->logger->warning(
                sprintf('Taxon with id %s has no code', $taxon->getId()),
            );

            return;
        }

        $variants = $this->taxonRepository->findAllEnabledIdsByTaxonCode($taxon->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        $taxon = $object->getTranslatable();
        Assert::isInstanceOf($taxon, TaxonInterface::class);
        if (null === $taxon->getCode()) {
            $this->logger->warning(
                sprintf('Taxon with id %s has no code', $taxon->getId()),
            );

            return;
        }

        $variants = $this->taxonRepository->findAllEnabledIdsByTaxonCode($taxon->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }
}
