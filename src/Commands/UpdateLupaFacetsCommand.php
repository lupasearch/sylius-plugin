<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Commands;

use LupaSearch\SyliusLupaSearchPlugin\Manager\Api\SearchQueriesApiManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\FacetInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Attribute\ProductAttributeRepositoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Option\ProductOptionRepositoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Transformer\FromAttributeToFacetTransformerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Transformer\FromOptionToFacetTransformerInterface;
use Sylius\Component\Product\Model\ProductAttributeInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use RuntimeException;

class UpdateLupaFacetsCommand extends Command
{
    public function __construct(
        private readonly SearchQueriesApiManagerInterface $searchQueriesApiManager,
        private readonly ProductAttributeRepositoryInterface $productAttributeRepository,
        private readonly ProductOptionRepositoryInterface $productOptionRepository,
        private readonly FromOptionToFacetTransformerInterface $fromOptionToFacetTransformer,
        private readonly FromAttributeToFacetTransformerInterface $fromAttributeToFacetTransformer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('lupasearch:facets:update')
            ->setDescription('Sends requests to update facets to Lupa');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = 100;
        $offset = 0;
        $io = new SymfonyStyle($input, $output);
        $io->info('Facet update to Lupa has started.');

        $initialSearchQuery = $this->searchQueriesApiManager->getSearchQuery();

        $configuration = $initialSearchQuery->getConfiguration();
        if (empty($configuration->getFacets())) {
            throw new RuntimeException('Initial search query has no facets. Aborting.');
        }

        $facetsFromOptionsToReplace = $this->getOptionFacets($limit, $offset);
        $facetsFromAttributesToReplace = $this->getAttributeFacets($limit, $offset);

        /** @var FacetInterface[] $facetsToReplace */
        $facetsToReplace = array_merge($facetsFromAttributesToReplace, $facetsFromOptionsToReplace);
        $filteredFacets = $this->filterFacets($facetsToReplace);
        $initialSearchQuery->setConfiguration($configuration->setFacets($filteredFacets));

        $this->searchQueriesApiManager->updateSearchQuery($initialSearchQuery);

        $io->success('Done.');

        return 0;
    }

    /**
     * @return array<string, mixed>
     */
    private function getAttributeFacets(int $limit, int $offset): array
    {
        $facets = [];

        $attributes = $this->productAttributeRepository->findAllAttributesWithTranslationsInBatches($limit, $offset);
        while (0 !== count($attributes)) {
            $newFacets = $this->prepareFacetsFromAttributes($attributes);
            $facets = [...$facets, ...$newFacets];

            $offset += $limit;
            $attributes = $this->productAttributeRepository->findAllAttributesWithTranslationsInBatches($limit, $offset);
        }

        return $facets;
    }

    /**
     * @return array<string, mixed>
     */
    private function getOptionFacets(int $limit, int $offset): array
    {
        $facets = [];

        $options = $this->productOptionRepository->findAllOptionsWithTranslationsInBatches($limit, $offset);
        while (0 !== count($options)) {
            $newFacets = $this->prepareFacetsFromOptions($options);
            $facets = [...$facets, ...$newFacets];

            $offset += $limit;
            $options = $this->productOptionRepository->findAllOptionsWithTranslationsInBatches($limit, $offset);
        }

        return $facets;
    }

    /**
     * @param array<ProductAttributeInterface> $productAttributes
     *
     * @return FacetInterface[]
     */
    private function prepareFacetsFromAttributes(array $productAttributes): array
    {
        $facets = [];

        foreach ($productAttributes as $productAttribute) {
            $facets[] = $this->fromAttributeToFacetTransformer->transform($productAttribute);
        }

        return $facets;
    }

    /**
     * @param array<ProductOptionInterface> $productOptions
     *
     * @return FacetInterface[]
     */
    private function prepareFacetsFromOptions(array $productOptions): array
    {
        $facets = [];

        foreach ($productOptions as $productOption) {
            $facets[] = $this->fromOptionToFacetTransformer->transform($productOption);
        }

        return $facets;
    }

    /**
     * @param FacetInterface[] $facets
     *
     * @return FacetInterface[]
     */
    private function filterFacets(array $facets): array
    {
        $uniqueFacets = [];

        foreach ($facets as $facet) {
            $uniqueFacets[$facet->getKey()] = $facet;
        }

        return array_values($uniqueFacets);
    }
}
