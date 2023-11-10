<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Commands;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIdsInterface;
use LupaSearch\SyliusLupaSearchPlugin\Factory\ExportToLupaFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\LupaExportableIds\LupaExportableIdsRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class InitiateLupaDocumentsExportCommand extends Command
{
    public function __construct(
        private readonly LupaExportableIdsRepositoryInterface $lupaExportableIdsRepository,
        private readonly ExportToLupaFactoryInterface $exportToLupaFactory,
        private readonly MessageBusInterface $lupasearchLupaBusExport,
        private readonly int $limit,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('lupasearch:documents:export:initiate')
            ->setDescription('Fetches all LupaExportableIds from database and puts respective variants to message queue for export to Lupa');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $offset = 0;
        $io = new SymfonyStyle($input, $output);
        $io->info('Product variant sending to Lupa has started.');

        $lupaExportableIds = $this->lupaExportableIdsRepository->findAllInBatches($this->limit, $offset);

        while (0 !== count($lupaExportableIds)) {
            $this->lupasearchLupaBusExport->dispatch($this->exportToLupaFactory->createForImporting($lupaExportableIds));
            $this->lupaExportableIdsRepository->deleteByIds(array_unique($this->gatherIdsToDelete($lupaExportableIds)));

            $offset += $this->limit;
            $lupaExportableIds = $this->lupaExportableIdsRepository->findAllInBatches($this->limit, $offset);
        }

        $io->success('Done.');

        return 0;
    }

    /**
     * @param LupaExportableIdsInterface[] $lupaExportableIds
     *
     * @return int[]
     */
    private function gatherIdsToDelete(array $lupaExportableIds): array
    {
        $ids = [];
        foreach ($lupaExportableIds as $lupaExportableId) {
            $ids[] = $lupaExportableId->getId();
        }

        return $ids;
    }
}
