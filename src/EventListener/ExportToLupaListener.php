<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\EventListener;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Factory\QueueExportToLupaFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ExportToLupaListener
{
    /**
     * @param LupaExportManagerInterface<object> $lupaExportManager
     */
    public function __construct(
        private readonly LupaExportManagerInterface $lupaExportManager,
        private readonly QueueExportToLupaFactoryInterface $queueExportToLupaFactory,
        private readonly MessageBusInterface $lupasearchLupaBusExport,
        private readonly LupaExportContextInterface $lupaExportContext,
    ) {
    }

    public function postUpdateOrPostPersist(object $object): void
    {
        $this->lupaExportManager->export($object);
    }

    public function postRemove(object $object): void
    {
        $this->lupaExportManager->delete($object);
    }

    public function postFlush(): void
    {
        if (!empty($this->lupaExportContext->getProductVariantIdsToAdd())) {
            $this->lupasearchLupaBusExport->dispatch(
                $this->queueExportToLupaFactory->createForImporting(
                    $this->lupaExportContext->getProductVariantIdsToAdd(),
                ),
            );
            $this->lupaExportContext->clearProductVariantIdsToAdd();
        }

        if (!empty($this->lupaExportContext->getProductVariantIdsToRemove())) {
            $this->lupasearchLupaBusExport->dispatch(
                $this->queueExportToLupaFactory->createForRemoving(
                    $this->lupaExportContext->getProductVariantIdsToRemove(),
                ),
            );
            $this->lupaExportContext->clearProductVariantIdsToRemove();
        }
    }
}
