<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Enum\FacetType;
use LupaSearch\SyliusLupaSearchPlugin\Factory\FacetFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\FacetInterface;
use Sylius\Component\Product\Model\ProductAttributeInterface;
use Webmozart\Assert\Assert;

class FromAttributeToFacetTransformer implements FromAttributeToFacetTransformerInterface
{
    public function __construct(
        private readonly FacetFactoryInterface $facetFactory,
        private readonly AttributeCodeTransformerInterface $attributeCodeTransformer,
        private readonly AttributeFacetTypeResolverInterface $attributeFacetTypeResolver
    ) {
    }

    public function transform(ProductAttributeInterface $productAttribute): FacetInterface
    {
        Assert::notNull($productAttribute->getCode());
        Assert::notNull($productAttribute->getTranslation()->getName());

        $facet = $this->facetFactory->createNew();
        $facet->setKey(
            $this->attributeCodeTransformer->transform(
                $productAttribute->getStorageType(),
                $productAttribute->getCode(),
                'attributes.'
            )
        );
        $facet->setType($this->attributeFacetTypeResolver->resolve($productAttribute->getStorageType()));
        $facet->setLabel($productAttribute->getTranslation()->getName());

        return $facet;
    }
}
