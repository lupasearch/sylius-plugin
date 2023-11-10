<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Api;

use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQuery;
use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQueryInterface;
use LupaSearch\Api\SearchQueriesApi;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SearchQueriesApiManager implements SearchQueriesApiManagerInterface
{
    public function __construct(
        private readonly SearchQueriesApi $searchQueriesApi,
        private readonly NormalizerInterface $lupaNormalizer,
        private readonly DenormalizerInterface $lupaDenormalizer,
        private readonly string $lupaIndexId,
        private readonly string $lupaSearchQueryId,
    ) {
    }

    public function updateSearchQuery(
        SearchQueryInterface $initialSearchQuery,
    ): void {
        /** @var array<string, mixed> $httpBody */
        $httpBody = $this->lupaNormalizer->normalize(
            $initialSearchQuery,
            null,
            ['groups' => ['lupasearch:search_query:read'], AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
        );

        $this->searchQueriesApi->updateSearchQuery(
            indexId: $this->lupaIndexId,
            searchQueryId: $this->lupaSearchQueryId,
            httpBody: $httpBody,
        );
    }

    public function getSearchQuery(): SearchQueryInterface
    {
        return $this->lupaDenormalizer->denormalize(
            $this->searchQueriesApi->getSearchQuery(
                indexId: $this->lupaIndexId,
                searchQueryId: $this->lupaSearchQueryId,
            ),
            SearchQuery::class,
        );
    }
}
