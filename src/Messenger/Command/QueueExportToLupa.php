<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Messenger\Command;

class QueueExportToLupa
{
    /** @var int[] */
    public array $productVariantsToAdd = [];

    /** @var int[] */
    public array $productVariantsToRemove = [];

    /**
     * @param int[] $productVariantsToAdd
     * @param int[] $productVariantsToRemove
     */
    public function __construct(array $productVariantsToAdd, array $productVariantsToRemove)
    {
        $this->productVariantsToAdd = $productVariantsToAdd;
        $this->productVariantsToRemove = $productVariantsToRemove;
    }

    /**
     * @return int[]
     */
    public function getProductVariantsToAdd(): array
    {
        return $this->productVariantsToAdd;
    }

    /**
     * @return int[]
     */
    public function getProductVariantsToRemove(): array
    {
        return $this->productVariantsToRemove;
    }
}
