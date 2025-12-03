<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\EventListener;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\OnFlushEventArgs;
use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use Sylius\Component\Core\Model\ProductInterface;

class ProductAttributeValueOnFlushListener
{
    public function __construct(private readonly LupaExportContextInterface $lupaContext) {}

    public function onFlush(OnFlushEventArgs $args): void
    {
        $entityManager = $args->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        foreach ($unitOfWork->getScheduledCollectionUpdates() as $collection) {
            $owner = $collection->getOwner();
            if (!$owner instanceof ProductInterface || $collection->getMapping()["fieldName"] !== "attributes") {
                continue;
            }

            $attributesRemoved = $this->haveAnyAttributesBeenRemoved($collection);
            if (!$attributesRemoved) {
                continue;
            }

            $variantIds = array_map(fn($variant) => $variant->getId(), $owner->getVariants()->toArray());
            foreach ($variantIds as $variantId) {
                $this->lupaContext->addIdToAdd($variantId);
            }
        }
    }

    private function haveAnyAttributesBeenRemoved(Collection $collection): bool
    {
        $oldIds = [];
        foreach ($collection->getSnapshot() as $item) {
            $oldIds[$item->getId()] = true;
        }

        $newIds = [];
        foreach ($collection->toArray() as $item) {
            $newIds[$item->getId()] = true;
        }

        // Only detect removals: any old attribute missing in new
        foreach ($oldIds as $id => $_) {
            if (!isset($newIds[$id])) {
                return true;
            }
        }

        return false;
    }
}
