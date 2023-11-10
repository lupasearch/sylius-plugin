<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Api;

use LupaSearch\SyliusLupaSearchPlugin\Model\BatchDeleteDocumentsInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

interface DocumentsApiManagerInterface
{
    /**
     * @throws ExceptionInterface
     */
    public function importDocuments(DocumentsInterface $documents): void;

    /**
     * @throws ExceptionInterface
     */
    public function batchDelete(BatchDeleteDocumentsInterface $batchDeleteDocuments): void;

    /**
     * @throws ExceptionInterface
     */
    public function replaceAllDocuments(DocumentsInterface $documents): void;
}
