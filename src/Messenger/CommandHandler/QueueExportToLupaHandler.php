<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Messenger\CommandHandler;

use LupaSearch\SyliusLupaSearchPlugin\Factory\LupaExportableIdsFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\QueueExportToLupa;
use LupaSearch\SyliusLupaSearchPlugin\Repository\LupaExportableIds\LupaExportableIdsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class QueueExportToLupaHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly LupaExportableIdsRepositoryInterface $lupaExportableIdsRepository,
        private readonly LupaExportableIdsFactoryInterface $lupaExportableIdsFactory,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(QueueExportToLupa $queueExportToLupa): void
    {
        $productVariantIdsToAdd = $this->lupaExportableIdsRepository->findIdsThatAreNotAlreadyThere(
            $queueExportToLupa->getProductVariantsToAdd(),
            'productVariantToAddId',
        );
        $productVariantIdsToRemove = $this->lupaExportableIdsRepository->findIdsThatAreNotAlreadyThere(
            $queueExportToLupa->getProductVariantsToRemove(),
            'productVariantToRemoveId',
        );

        if (!empty($productVariantIdsToAdd)) {
            foreach ($productVariantIdsToAdd as $productVariantIdToAdd) {
                $lupaExportableIds = $this->lupaExportableIdsFactory->createNew();
                $lupaExportableIds->setProductVariantToAddId($productVariantIdToAdd);
                $this->entityManager->persist($lupaExportableIds);
            }
        }

        if (!empty($productVariantIdsToRemove)) {
            foreach ($productVariantIdsToRemove as $productVariantIdToRemove) {
                $lupaExportableIds = $this->lupaExportableIdsFactory->createNew();
                $lupaExportableIds->setProductVariantToRemoveId($productVariantIdToRemove);
                $this->entityManager->persist($lupaExportableIds);
            }
        }

        if (!empty($productVariantIdsToAdd) || !empty($productVariantIdsToRemove)) {
            $this->entityManager->flush();
        }
    }
}
