<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Factory\BatchDeleteDocumentsFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Generator\DocumentIdGeneratorInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\BatchDeleteDocumentsInterface;

class FromVariantToBatchDeleteDocumentsTransformer implements FromVariantToBatchDeleteDocumentsTransformerInterface
{
    public function __construct(
        private readonly BatchDeleteDocumentsFactoryInterface $batchDeleteDocumentsFactory,
        private readonly DocumentIdGeneratorInterface $documentIdGenerator,
    ) {
    }

    public function transform(array $productVariants): BatchDeleteDocumentsInterface
    {
        $ids = [];

        foreach ($productVariants as $productVariant) {
            $ids[] = $this->documentIdGenerator->generateFromVariant($productVariant);
        }

        return $this->batchDeleteDocumentsFactory->createFromIds($ids);
    }
}
