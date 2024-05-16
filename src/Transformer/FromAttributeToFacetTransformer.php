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
    public function __construct(private readonly FacetFactoryInterface $facetFactory)
    {
    }

    public function transform(ProductAttributeInterface $productAttribute): FacetInterface
    {
        $facet = $this->facetFactory->createNew();

        Assert::notNull($productAttribute->getCode());
        Assert::notNull($productAttribute->getTranslation()->getName());
        $facet->setKey('attributes.' . $productAttribute->getCode());
        $facet->setType(FacetType::Terms);
        $facet->setLabel($productAttribute->getTranslation()->getName());

        return $facet;
    }
}
