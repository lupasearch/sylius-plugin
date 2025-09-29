<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

interface AttributeCodeTransformerInterface
{
    public function transform(
        string $attributeType,
        string $attributeCode,
        ?string $defaultPrefix
    ): string;
}
