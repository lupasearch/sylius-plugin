<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Api;

use LupaSearch\SyliusLupaSearchPlugin\Model\BatchDeleteDocumentsInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use LupaSearch\Api\DocumentsApi;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DocumentsApiManager implements DocumentsApiManagerInterface
{
    public function __construct(
        private readonly DocumentsApi $documentsApi,
        private readonly NormalizerInterface $normalizer,
        private readonly string $lupaIndexId,
    ) {
    }

    public function importDocuments(DocumentsInterface $documents): void
    {
        if (empty($documents->getDocuments())) {
            return;
        }

        /** @var array<string, mixed> $httpBody */
        $httpBody = $this->normalizer->normalize($documents, null, ['groups' => ['lupasearch:document:read']]);
        $this->documentsApi->importDocuments(
            indexId: $this->lupaIndexId,
            httpBody: $httpBody,
        );
    }

    public function batchDelete(BatchDeleteDocumentsInterface $batchDeleteDocuments): void
    {
        if (empty($batchDeleteDocuments->getIds())) {
            return;
        }

        /** @var array<string, mixed> $httpBody */
        $httpBody = $this->normalizer->normalize($batchDeleteDocuments);
        $this->documentsApi->batchDelete(
            indexId: $this->lupaIndexId,
            httpBody: $httpBody,
        );
    }

    public function replaceAllDocuments(DocumentsInterface $documents): void
    {
        /** @var array<string, mixed> $httpBody */
        $httpBody = $this->normalizer->normalize($documents, null, ['groups' => ['lupasearch:document:read']]);
        $this->documentsApi->replaceAllDocuments(
            indexId: $this->lupaIndexId,
            httpBody: $httpBody,
        );
    }
}
