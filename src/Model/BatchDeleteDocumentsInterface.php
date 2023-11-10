<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

interface BatchDeleteDocumentsInterface
{
    /**
     * @return string[] $ids
     */
    public function getIds(): array;

    public function addId(string $id): BatchDeleteDocuments;
}
