<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Enum\FacetType;
use LupaSearch\SyliusLupaSearchPlugin\Factory\FacetFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\FacetInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Webmozart\Assert\Assert;

class FromOptionToFacetTransformer implements FromOptionToFacetTransformerInterface
{
    public function __construct(private readonly FacetFactoryInterface $facetFactory)
    {
    }

    public function transform(ProductOptionInterface $productOption): FacetInterface
    {
        $facet = $this->facetFactory->createNew();

        Assert::notNull($productOption->getCode());
        Assert::notNull($productOption->getTranslation()->getName());
        $facet->setKey('attributes.' . $productOption->getCode());
        $facet->setType(FacetType::Terms);
        $facet->setLabel($productOption->getTranslation()->getName());

        return $facet;
    }
}
