<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\BatchDeleteDocuments;
use LupaSearch\SyliusLupaSearchPlugin\Model\BatchDeleteDocumentsInterface;

class BatchDeleteDocumentsFactory implements BatchDeleteDocumentsFactoryInterface
{
    public function createNew(): BatchDeleteDocumentsInterface
    {
        return new BatchDeleteDocuments();
    }

    public function createFromIds(array $ids): BatchDeleteDocumentsInterface
    {
        $batchDeleteDocuments = $this->createNew();
        foreach ($ids as $id) {
            $batchDeleteDocuments->addId($id);
        }

        return $batchDeleteDocuments;
    }
}
