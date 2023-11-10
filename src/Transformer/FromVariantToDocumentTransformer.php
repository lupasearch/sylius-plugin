<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Factory\DocumentFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Factory\DocumentsFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Generator\DocumentIdGeneratorInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

class FromVariantToDocumentTransformer implements FromVariantToDocumentTransformerInterface
{
    public function __construct(
        private readonly DocumentFactoryInterface $documentFactory,
        private readonly DocumentsFactoryInterface $documentsFactory,
        private readonly DocumentIdGeneratorInterface $documentIdGenerator,
    ) {
    }

    public function transform(ProductVariantInterface $productVariant): DocumentInterface
    {
        $document = $this->documentFactory->createNew();
        $document->setId($this->documentIdGenerator->generateFromVariant($productVariant));
        $document->setCode($productVariant->getCode());
        $document->setName($productVariant->getName());
        $document->setVariantCode($productVariant->getCode());
        $document->setSlug($productVariant->getProduct()?->getSlug());

        $image = $productVariant->getImages()->first();
        if ($image instanceof ImageInterface) {
            $document->setMainImage($image->getPath());
        }

        foreach ($productVariant->getOptionValues() as $optionValue) {
            $document->addAttribute((string) $optionValue->getOptionCode(), (string) $optionValue->getValue());
        }

        foreach ($productVariant->getProduct()?->getAttributes() ?? [] as $attribute) {
            $document->addAttribute((string) $attribute->getCode(), (string) $attribute->getValue());
        }

        /** @var ProductInterface|null $product */
        $product = $productVariant->getProduct();
        if (null === $product) {
            return $document;
        }

        $document->setTaxonCodes($this->getTaxonCodes($product));
        $document->setMainTaxonCode($product->getMainTaxon()?->getCode());
        $document->setProductId((string) $product->getId());

        return $document;
    }

    public function transformAll(array $productVariants): DocumentsInterface
    {
        $documentArray = [];

        foreach ($productVariants as $productVariant) {
            $documentArray[] = $this->transform($productVariant);
        }

        return $this->documentsFactory->createFromDocumentArray($documentArray);
    }

    /**
     * @return array<int, string>
     */
    private function getTaxonCodes(ProductInterface $product): array
    {
        $taxonCodes = [];
        foreach ($product->getTaxons() as $taxon) {
            if (!$taxon->getCode()) {
                continue;
            }

            $taxonCodes[] = $taxon->getCode();
        }

        return $taxonCodes;
    }
}
