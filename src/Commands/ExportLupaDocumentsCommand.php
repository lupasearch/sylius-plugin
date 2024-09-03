<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Commands;

use LupaSearch\SyliusLupaSearchPlugin\Manager\Api\DocumentsApiManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Transformer\FromVariantToDocumentTransformerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ExportLupaDocumentsCommand extends Command
{
    public function __construct(
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly FromVariantToDocumentTransformerInterface $fromVariantToDocumentTransformer,
        private readonly DocumentsApiManagerInterface $documentsApiManager,
        private readonly int $limit,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('lupasearch:documents:export')
            ->setDescription('Export all variants as documents to Lupa');
    }

    /**
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $offset = 0;
        $io = new SymfonyStyle($input, $output);
        $io->info('Product variant sending to Lupa has started.');

        $productVariants = $this->productVariantRepository->findAllEnabledInBatches($this->limit, $offset);

        while (0 !== count($productVariants)) {
            $documentsToReplace = $this->fromVariantToDocumentTransformer->transformAll($productVariants);

            if ($this->limit > count($productVariants)) {
                $documentsToReplace->setFinished(true);
            }

            $this->documentsApiManager->replaceAllDocuments(documents: $documentsToReplace);

            $offset += $this->limit;
            $productVariants = $this->productVariantRepository->findAllEnabledInBatches($this->limit, $offset);
        }

        $io->success('Done.');

        return 0;
    }
}
