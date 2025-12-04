<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Webmozart\Assert\Assert;
use LupaSearch\SyliusLupaSearchPlugin\Enum\FacetType;

class AttributeFacetTypeResolver implements AttributeFacetTypeResolverInterface
{
    private const NUMERIC_ATTRIBUTE_TYPES = [
        AttributeValueInterface::STORAGE_INTEGER,
        AttributeValueInterface::STORAGE_FLOAT,
    ];

    public function __construct(private readonly ?string $numericFacetType) {}

    public function resolve(string $attributeType): FacetType
    {
        Assert::notEmpty($attributeType);

        if ($this->numericFacetType === FacetType::Stats->value && in_array($attributeType, self::NUMERIC_ATTRIBUTE_TYPES, true)) {
            return FacetType::Stats;
        }

        return FacetType::Terms;
    }
}
