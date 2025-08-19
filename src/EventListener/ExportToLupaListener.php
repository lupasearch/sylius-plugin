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
        if (!$this->lupaExportContext->isQueueForExport()) {
            return;
        }

        $this->lupaExportManager->export($object);
    }

    public function postRemove(object $object): void
    {
        if (!$this->lupaExportContext->isQueueForExport()) {
            return;
        }

        $this->lupaExportManager->delete($object);
    }

    public function postFlush(): void
    {
        if (!$this->lupaExportContext->isQueueForExport()) {
            return;
        }

        $idsToAdd = $this->lupaExportContext->getIdsToAdd();
        $idsToRemove = $this->lupaExportContext->getIdsToRemove();

        if (empty($idsToAdd) && empty($idsToRemove)) {
            return;
        }

        $this->lupaExportContext->setQueueForExport(false);
        try {
            if (!empty($idsToAdd)) {
                $this->lupasearchLupaBusExport->dispatch(
                    $this->queueExportToLupaFactory->createForImporting(
                        $idsToAdd,
                    ),
                );
                $this->lupaExportContext->clearIdsToAdd();
            }
    
            if (!empty($idsToRemove)) {
                $this->lupasearchLupaBusExport->dispatch(
                    $this->queueExportToLupaFactory->createForRemoving(
                        $idsToRemove,
                    ),
                );
                $this->lupaExportContext->clearIdsToRemove();
            }
        } finally {
            $this->lupaExportContext->setQueueForExport(true);
        }
        
    }
}
