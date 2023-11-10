<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

use LupaSearch\SyliusLupaSearchPlugin\Enum\SearchQueryMatch;

class SearchQueryConfiguration implements SearchQueryConfigurationInterface
{
    private ?OrderedMapInterface $queryFields = null;

    private ?OrderedMapInterface $priorityFields = null;

    private ?SearchQueryMatch $match = SearchQueryMatch::Any;

    private ?OrderedMapInterface $boostPhrase = null;

    private ?OrderedMapInterface $boost = null;

    private ?OrderedMapInterface $didYouMean = null;

    private ?OrderedMapInterface $similarQueries = null;

    private ?OrderedMapInterface $similarResults = null;

    private ?OrderedMapInterface $aiSynonyms = null;

    /** @var string[] */
    private ?array $selectFields = null;

    /** @var string[] */
    private ?array $selectableFields = null;

    /** @var FacetInterface[] */
    private array $facets = [];

    private ?OrderedMapInterface $dynamicFacets = null;

    private ?OrderedMapInterface $filters = null;

    private ?OrderedMapInterface $exclusionFilters = null;

    /** @var string[] */
    private ?array $filterableFields = null;

    private ?int $offset = 0;

    private ?string $limit = null;

    /** @var OrderedMapInterface[] */
    private ?array $sort = null;

    private ?OrderedMapInterface $statisticalBoost = null;

    private ?OrderedMapInterface $personalization = null;

    private ?OrderedMapInterface $collapse = null;

    private bool $exactTotalCount = false;

    private ?float $exactMatchMultiplier = 1;

    /** @var string[] */
    private ?array $mustIncludeIds = null;

    /** @var string[] */
    private ?array $mustExcludeIds = null;

    /** @var string[] */
    private ?array $forceItemOrder = null;

    public function getQueryFields(): ?OrderedMapInterface
    {
        return $this->queryFields;
    }

    public function setQueryFields(?OrderedMapInterface $queryFields): SearchQueryConfigurationInterface
    {
        $this->queryFields = $queryFields;

        return $this;
    }

    public function getPriorityFields(): ?OrderedMapInterface
    {
        return $this->priorityFields;
    }

    public function setPriorityFields(?OrderedMapInterface $priorityFields): SearchQueryConfigurationInterface
    {
        $this->priorityFields = $priorityFields;

        return $this;
    }

    public function getMatch(): ?SearchQueryMatch
    {
        return $this->match;
    }

    public function setMatch(?SearchQueryMatch $match): SearchQueryConfigurationInterface
    {
        if (!$match) {
            return $this;
        }

        $this->match = $match;

        return $this;
    }

    public function getBoostPhrase(): ?OrderedMapInterface
    {
        return $this->boostPhrase;
    }

    public function setBoostPhrase(?OrderedMapInterface $boostPhrase): SearchQueryConfigurationInterface
    {
        $this->boostPhrase = $boostPhrase;

        return $this;
    }

    public function getBoost(): ?OrderedMapInterface
    {
        return $this->boost;
    }

    public function setBoost(?OrderedMapInterface $boost): SearchQueryConfigurationInterface
    {
        $this->boost = $boost;

        return $this;
    }

    public function getDidYouMean(): ?OrderedMapInterface
    {
        return $this->didYouMean;
    }

    public function setDidYouMean(?OrderedMapInterface $didYouMean): SearchQueryConfigurationInterface
    {
        $this->didYouMean = $didYouMean;

        return $this;
    }

    public function getSimilarQueries(): ?OrderedMapInterface
    {
        return $this->similarQueries;
    }

    public function setSimilarQueries(?OrderedMapInterface $similarQueries): SearchQueryConfigurationInterface
    {
        $this->similarQueries = $similarQueries;

        return $this;
    }

    public function getSimilarResults(): ?OrderedMapInterface
    {
        return $this->similarResults;
    }

    public function setSimilarResults(?OrderedMapInterface $similarResults): SearchQueryConfigurationInterface
    {
        $this->similarResults = $similarResults;

        return $this;
    }

    public function getAiSynonyms(): ?OrderedMapInterface
    {
        return $this->aiSynonyms;
    }

    public function setAiSynonyms(?OrderedMapInterface $aiSynonyms): SearchQueryConfigurationInterface
    {
        $this->aiSynonyms = $aiSynonyms;

        return $this;
    }

    public function getSelectFields(): ?array
    {
        return $this->selectFields;
    }

    public function setSelectFields(?array $selectFields): SearchQueryConfigurationInterface
    {
        $this->selectFields = $selectFields ? array_values(array_unique($selectFields)) : null;

        return $this;
    }

    public function getSelectableFields(): ?array
    {
        return $this->selectableFields;
    }

    public function setSelectableFields(?array $selectableFields): SearchQueryConfigurationInterface
    {
        $this->selectableFields = $selectableFields ? array_values(array_unique($selectableFields)) : null;

        return $this;
    }

    public function getFacets(): array
    {
        return $this->facets;
    }

    public function setFacets(array $facets): SearchQueryConfigurationInterface
    {
        $this->facets = array_values($facets);

        return $this;
    }

    public function getDynamicFacets(): ?OrderedMapInterface
    {
        return $this->dynamicFacets;
    }

    public function setDynamicFacets(?OrderedMapInterface $dynamicFacets): SearchQueryConfigurationInterface
    {
        $this->dynamicFacets = $dynamicFacets;

        return $this;
    }

    public function getFilters(): ?OrderedMapInterface
    {
        return $this->filters;
    }

    public function setFilters(?OrderedMapInterface $filters): SearchQueryConfigurationInterface
    {
        $this->filters = $filters;

        return $this;
    }

    public function getExclusionFilters(): ?OrderedMapInterface
    {
        return $this->exclusionFilters;
    }

    public function setExclusionFilters(?OrderedMapInterface $exclusionFilters): SearchQueryConfigurationInterface
    {
        $this->exclusionFilters = $exclusionFilters;

        return $this;
    }

    public function getFilterableFields(): ?array
    {
        return $this->filterableFields;
    }

    public function setFilterableFields(?array $filterableFields): SearchQueryConfigurationInterface
    {
        $this->filterableFields = $filterableFields ? array_values($filterableFields) : null;

        return $this;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function setOffset(?int $offset): SearchQueryConfigurationInterface
    {
        $this->offset = $offset;

        return $this;
    }

    public function getLimit(): ?string
    {
        return $this->limit;
    }

    public function setLimit(?string $limit): SearchQueryConfigurationInterface
    {
        $this->limit = $limit;

        return $this;
    }

    public function getSort(): ?array
    {
        return $this->sort;
    }

    public function setSort(?array $sort): SearchQueryConfigurationInterface
    {
        $this->sort = $sort ? array_values($sort) : null;

        return $this;
    }

    public function getStatisticalBoost(): ?OrderedMapInterface
    {
        return $this->statisticalBoost;
    }

    public function setStatisticalBoost(?OrderedMapInterface $statisticalBoost): SearchQueryConfigurationInterface
    {
        $this->statisticalBoost = $statisticalBoost;

        return $this;
    }

    public function getPersonalization(): ?OrderedMapInterface
    {
        return $this->personalization;
    }

    public function setPersonalization(?OrderedMapInterface $personalization): SearchQueryConfigurationInterface
    {
        $this->personalization = $personalization;

        return $this;
    }

    public function getCollapse(): ?OrderedMapInterface
    {
        return $this->collapse;
    }

    public function setCollapse(?OrderedMapInterface $collapse): SearchQueryConfigurationInterface
    {
        $this->collapse = $collapse;

        return $this;
    }

    public function isExactTotalCount(): bool
    {
        return $this->exactTotalCount;
    }

    public function setExactTotalCount(bool $exactTotalCount): SearchQueryConfigurationInterface
    {
        $this->exactTotalCount = $exactTotalCount;

        return $this;
    }

    public function getExactMatchMultiplier(): ?float
    {
        return $this->exactMatchMultiplier;
    }

    public function setExactMatchMultiplier(float|int|null $exactMatchMultiplier): SearchQueryConfigurationInterface
    {
        $this->exactMatchMultiplier = (float) $exactMatchMultiplier;

        return $this;
    }

    public function getMustIncludeIds(): ?array
    {
        return $this->mustIncludeIds;
    }

    public function setMustIncludeIds(?array $mustIncludeIds): SearchQueryConfigurationInterface
    {
        $this->mustIncludeIds = $mustIncludeIds ? array_values($mustIncludeIds) : null;

        return $this;
    }

    public function getMustExcludeIds(): ?array
    {
        return $this->mustExcludeIds;
    }

    public function setMustExcludeIds(?array $mustExcludeIds): SearchQueryConfigurationInterface
    {
        $this->mustExcludeIds = $mustExcludeIds ? array_values($mustExcludeIds) : null;

        return $this;
    }

    public function getForceItemOrder(): ?array
    {
        return $this->forceItemOrder;
    }

    public function setForceItemOrder(?array $forceItemOrder): SearchQueryConfigurationInterface
    {
        $this->forceItemOrder = $forceItemOrder ? array_values($forceItemOrder) : null;

        return $this;
    }
}
