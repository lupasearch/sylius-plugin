<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Messenger\CommandHandler;

use LupaSearch\SyliusLupaSearchPlugin\Manager\Api\DocumentsApiManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\ExportToLupa;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Transformer\FromVariantToBatchDeleteDocumentsTransformerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Transformer\FromVariantToDocumentTransformerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ExportToLupaHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly DocumentsApiManagerInterface $documentsApiManager,
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly FromVariantToDocumentTransformerInterface $fromVariantToDocumentTransformer,
        private readonly FromVariantToBatchDeleteDocumentsTransformerInterface $fromVariantToBatchDeleteDocumentsTransformer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(ExportToLupa $exportToLupa): void
    {
        $productVariantsIdsToAdd = [];
        $productVariantsIdsToRemove = [];

        foreach ($exportToLupa->getLupaExportableIds() as $lupaExportableId) {
            if (null !== $lupaExportableId->getProductVariantToAddId()) {
                $productVariantsIdsToAdd[] = $lupaExportableId->getProductVariantToAddId();
            }

            if (null !== $lupaExportableId->getProductVariantToRemoveId()) {
                $productVariantsIdsToRemove[] = $lupaExportableId->getProductVariantToRemoveId();
            }
        }

        $productVariantsToAdd = $this->productVariantRepository->findEnabledByIds($productVariantsIdsToAdd);
        $productVariantsToRemove = $this->productVariantRepository->findEnabledByIds($productVariantsIdsToRemove);

        $this->documentsApiManager->importDocuments(
            $this->fromVariantToDocumentTransformer->transformAll($productVariantsToAdd),
        );
        $this->documentsApiManager->batchDelete(
            $this->fromVariantToBatchDeleteDocumentsTransformer->transform($productVariantsToRemove),
        );
    }
}
