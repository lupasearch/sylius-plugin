<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\Documents;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;

class DocumentsFactory implements DocumentsFactoryInterface
{
    public function createNew(): DocumentsInterface
    {
        return new Documents();
    }

    public function createFromDocumentArray(array $documentArray): DocumentsInterface
    {
        $documents = $this->createNew();
        foreach ($documentArray as $document) {
            $documents->addDocument($document);
        }

        return $documents;
    }
}
