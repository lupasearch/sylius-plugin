<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Webmozart\Assert\Assert;

class AttributeCodeTransformer implements AttributeCodeTransformerInterface
{
    private const NUMERIC_ATTRIBUTE_TYPES = [
        AttributeValueInterface::STORAGE_DATE,
        AttributeValueInterface::STORAGE_DATETIME,
        AttributeValueInterface::STORAGE_FLOAT,
        AttributeValueInterface::STORAGE_INTEGER,
    ];

    private const TEXT_ATTRIBUTE_TYPES = [
        AttributeValueInterface::STORAGE_BOOLEAN,
        AttributeValueInterface::STORAGE_JSON,
        AttributeValueInterface::STORAGE_TEXT,
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
