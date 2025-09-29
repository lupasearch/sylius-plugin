<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Factory\DocumentFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Factory\DocumentsFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Generator\DocumentIdGeneratorInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use Sylius\Component\Attribute\AttributeType\DateAttributeType;
use Sylius\Component\Attribute\AttributeType\DatetimeAttributeType;
use Sylius\Component\Attribute\AttributeType\TextAttributeType;
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
                (string) $optionValue->getOptionCode(),
                $this->normalizeAttributeValue(TextAttributeType::TYPE, $optionValue->getValue())
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

        foreach ($product->getAttributes() ?? [] as $attribute) {
            $document->addAttribute(
                $this->attributeCodeTransformer->transform(
                    $attribute->getType(),
                    $attribute->getCode()
                ),
                $this->normalizeAttributeValue(
                    $attribute->getType(),
                    $attribute->getValue()
                )
            );
        }

        return $document;
    }

    private function normalizeAttributeValue(string $attributeType, $value)
    {
        if (in_array($attributeType, [DateAttributeType::TYPE, DatetimeAttributeType::TYPE])) {
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
