<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use Sylius\Component\Attribute\AttributeType\CheckboxAttributeType;
use Sylius\Component\Attribute\AttributeType\DateAttributeType;
use Sylius\Component\Attribute\AttributeType\DatetimeAttributeType;
use Sylius\Component\Attribute\AttributeType\FloatAttributeType;
use Sylius\Component\Attribute\AttributeType\IntegerAttributeType;
use Sylius\Component\Attribute\AttributeType\PercentAttributeType;
use Sylius\Component\Attribute\AttributeType\SelectAttributeType;
use Sylius\Component\Attribute\AttributeType\TextareaAttributeType;
use Sylius\Component\Attribute\AttributeType\TextAttributeType;
use Webmozart\Assert\Assert;

class AttributeCodeTransformer implements AttributeCodeTransformerInterface
{
    private const NUMERIC_ATTRIBUTE_TYPES = [
        DateAttributeType::TYPE, 
        DatetimeAttributeType::TYPE, 
        FloatAttributeType::TYPE, 
        IntegerAttributeType::TYPE, 
        PercentAttributeType::TYPE
    ];

    private const TEXT_ATTRIBUTE_TYPES = [
        TextAttributeType::TYPE, 
        TextareaAttributeType::TYPE, 
        SelectAttributeType::TYPE, 
        CheckboxAttributeType::TYPE
    ];

    public function __construct(
        private readonly ?string $typeNumericPrefix,
        private readonly ?string $typeTextPrefix,
    ) {}

    public function transform(
        string $attributeType, 
        string $attributeCode, 
        ?string $defaultPrefix = null
    ): string {
        Assert::notEmpty($attributeType);
        Assert::notEmpty($attributeCode);

        $prefix = match (true) {
            in_array($attributeType, self::NUMERIC_ATTRIBUTE_TYPES, true) && $this->typeNumericPrefix => $this->typeNumericPrefix,
            in_array($attributeType, self::TEXT_ATTRIBUTE_TYPES, true) && $this->typeTextPrefix => $this->typeTextPrefix,
            default => $defaultPrefix,
        };

        return $prefix . $attributeCode;
    }
}
