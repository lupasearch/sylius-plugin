<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

class BatchDeleteDocuments implements BatchDeleteDocumentsInterface
{
    /** @var string[] */
    private array $ids = [];

    /**
     * @return string[] $ids
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    public function addId(string $id): self
    {
        $this->ids[] = $id;

        return $this;
    }
}
