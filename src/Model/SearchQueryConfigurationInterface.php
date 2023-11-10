<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

use LupaSearch\SyliusLupaSearchPlugin\Enum\SearchQueryMatch;

interface SearchQueryConfigurationInterface
{
    public function getQueryFields(): ?OrderedMapInterface;

    public function setQueryFields(?OrderedMapInterface $queryFields): self;

    public function getPriorityFields(): ?OrderedMapInterface;

    public function setPriorityFields(?OrderedMapInterface $priorityFields): self;

    public function getMatch(): ?SearchQueryMatch;

    public function setMatch(?SearchQueryMatch $match): self;

    public function getBoostPhrase(): ?OrderedMapInterface;

    public function setBoostPhrase(?OrderedMapInterface $boostPhrase): self;

    public function getBoost(): ?OrderedMapInterface;

    public function setBoost(?OrderedMapInterface $boost): self;

    public function getDidYouMean(): ?OrderedMapInterface;

    public function setDidYouMean(?OrderedMapInterface $didYouMean): self;

    public function getSimilarQueries(): ?OrderedMapInterface;

    public function setSimilarQueries(?OrderedMapInterface $similarQueries): self;

    public function getSimilarResults(): ?OrderedMapInterface;

    public function setSimilarResults(?OrderedMapInterface $similarResults): self;

    public function getAiSynonyms(): ?OrderedMapInterface;

    public function setAiSynonyms(?OrderedMapInterface $aiSynonyms): self;

    /**
     * @return ?string[]
     */
    public function getSelectFields(): ?array;

    /**
     * @param string[] $selectFields
     */
    public function setSelectFields(?array $selectFields): self;

    /**
     * @return ?string[]
     */
    public function getSelectableFields(): ?array;

    /**
     * @param string[] $selectableFields
     */
    public function setSelectableFields(?array $selectableFields): self;

    /**
     * @return FacetInterface[]
     */
    public function getFacets(): array;

    /**
     * @param FacetInterface[] $facets
     */
    public function setFacets(array $facets): self;

    public function getDynamicFacets(): ?OrderedMapInterface;

    public function setDynamicFacets(?OrderedMapInterface $dynamicFacets): self;

    public function getFilters(): ?OrderedMapInterface;

    public function setFilters(?OrderedMapInterface $filters): self;

    public function getExclusionFilters(): ?OrderedMapInterface;

    public function setExclusionFilters(?OrderedMapInterface $exclusionFilters): self;

    /**
     * @return string[]
     */
    public function getFilterableFields(): ?array;

    /**
     * @param string[] $filterableFields
     */
    public function setFilterableFields(?array $filterableFields): self;

    public function getOffset(): ?int;

    public function setOffset(int $offset): self;

    /**
     * @return OrderedMapInterface[]
     */
    public function getSort(): ?array;

    /**
     * @param OrderedMapInterface[] $sort
     */
    public function setSort(?array $sort): self;

    public function getStatisticalBoost(): ?OrderedMapInterface;

    public function setStatisticalBoost(?OrderedMapInterface $statisticalBoost): self;

    public function getPersonalization(): ?OrderedMapInterface;

    public function setPersonalization(?OrderedMapInterface $personalization): self;

    public function getCollapse(): ?OrderedMapInterface;

    public function setCollapse(?OrderedMapInterface $collapse): self;

    public function isExactTotalCount(): bool;

    public function setExactTotalCount(bool $exactTotalCount): self;

    public function getExactMatchMultiplier(): ?float;

    public function setExactMatchMultiplier(?float $exactMatchMultiplier): self;

    /**
     * @return string[]
     */
    public function getMustIncludeIds(): ?array;

    /**
     * @param string[] $mustIncludeIds
     */
    public function setMustIncludeIds(?array $mustIncludeIds): self;

    /**
     * @return string[]
     */
    public function getMustExcludeIds(): ?array;

    /**
     * @param string[] $mustExcludeIds
     */
    public function setMustExcludeIds(?array $mustExcludeIds): self;

    /**
     * @return string[]
     */
    public function getForceItemOrder(): ?array;

    /**
     * @param string[] $forceItemOrder
     */
    public function setForceItemOrder(?array $forceItemOrder): self;

    public function getLimit(): ?string;

    public function setLimit(?string $limit): self;
}
