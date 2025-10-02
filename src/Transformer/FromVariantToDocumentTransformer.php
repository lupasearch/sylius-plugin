<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Factory\DocumentFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Factory\DocumentsFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Generator\DocumentIdGeneratorInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Core\Model\ProductImageInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

use function in_array;

class FromVariantToDocumentTransformer implements FromVariantToDocumentTransformerInterface
{
    public function __construct(
        private readonly DocumentFactoryInterface $documentFactory,
        private readonly DocumentsFactoryInterface $documentsFactory,
        private readonly DocumentIdGeneratorInterface $documentIdGenerator,
        private readonly AttributeCodeTransformerInterface $attributeCodeTransformer,
    ) {
    }

    public function transform(ProductVariantInterface $productVariant): DocumentInterface
    {
        $document = $this->documentFactory->createNew();

        $document->setId($this->documentIdGenerator->generateFromVariant($productVariant));
        $document->setCode($productVariant->getCode());
        $document->setName($productVariant->getName());
        $document->setVariantCode($productVariant->getCode());

        $image = $productVariant->getImages()->first();
        if ($image instanceof ImageInterface) {
            $document->setMainImage($image->getPath());
        }

        foreach ($productVariant->getOptionValues() as $optionValue) {
            $document->addAttribute(
                $this->attributeCodeTransformer->transform(
                    AttributeValueInterface::STORAGE_TEXT,
                    (string) $optionValue->getOptionCode(),
                ),
                $this->normalizeAttributeValue(AttributeValueInterface::STORAGE_TEXT, $optionValue->getValue()),
            );
        }

        /** @var ProductInterface|null $product */
        $product = $productVariant->getProduct();
        if (null === $product) {
            return $document;
        }

        return $this->populateWithProductProperties($document, $product);
    }

    public function transformAll(array $productVariants): DocumentsInterface
    {
        $documentArray = [];

        foreach ($productVariants as $productVariant) {
            $documentArray[] = $this->transform($productVariant);
        }

        return $this->documentsFactory->createFromDocumentArray($documentArray);
    }

    protected function populateWithProductProperties(DocumentInterface $document, ProductInterface $product): DocumentInterface
    {
        $document->setTaxonCodes($this->getTaxonCodes($product));
        $document->setMainTaxonCode($product->getMainTaxon()?->getCode());
        $document->setProductId((string) $product->getId());
        $document->setProductName($product->getName());
        $document->setSlug($product->getSlug());

        $productImage = $product->getImages()->first();
        if ($productImage instanceof ProductImageInterface) {
            $document->setProductMainImage($productImage->getPath());
        }

        foreach ($product->getAttributes() ?? [] as $attributeValue) {
            $attribute = $attributeValue->getAttribute();
            $document->addAttribute(
                $this->attributeCodeTransformer->transform(
                    $attribute->getStorageType(),
                    $attribute->getCode()
                ),
                $this->normalizeAttributeValue(
                    $attribute->getStorageType(),
                    $attributeValue->getValue()
                )
            );
        }

        return $document;
    }

    private function normalizeAttributeValue(string $attributeValueType, $value)
    {
        if (
            in_array($attributeValueType, [
                AttributeValueInterface::STORAGE_DATE,
                AttributeValueInterface::STORAGE_DATETIME,
            ])
        ) {
            if ($value instanceof \DateTimeInterface) {
                return $value->getTimestamp();
            }

            return null;
        }

        return $value;
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
