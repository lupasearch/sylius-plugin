<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

class SearchQuery implements SearchQueryInterface
{
    private ?string $id = null;

    private ?string $description = null;

    private SearchQueryConfigurationInterface $configuration;

    private bool $debugMode = false;

    private ?string $queryKey = null;

    private ?string $createdByUser = null;

    private ?string $createdAt = null;

    private ?string $updatedAt = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): SearchQueryInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): SearchQueryInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getConfiguration(): SearchQueryConfigurationInterface
    {
        return $this->configuration;
    }

    public function setConfiguration(SearchQueryConfigurationInterface $configuration): SearchQueryInterface
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function isDebugMode(): bool
    {
        return $this->debugMode;
    }

    public function setDebugMode(bool|int $debugMode): SearchQueryInterface
    {
        $this->debugMode = (bool) $debugMode;

        return $this;
    }

    public function getQueryKey(): ?string
    {
        return $this->queryKey;
    }

    public function setQueryKey(?string $queryKey): SearchQueryInterface
    {
        $this->queryKey = $queryKey;

        return $this;
    }

    public function getCreatedByUser(): ?string
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(?string $createdByUser): SearchQueryInterface
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): SearchQueryInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): SearchQueryInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
