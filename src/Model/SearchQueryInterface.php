<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

interface SearchQueryInterface
{
    public function getId(): ?string;

    public function setId(?string $id): self;

    public function getDescription(): ?string;

    public function setDescription(?string $description): self;

    public function getConfiguration(): SearchQueryConfigurationInterface;

    public function setConfiguration(SearchQueryConfigurationInterface $configuration): self;

    public function isDebugMode(): bool;

    public function setDebugMode(bool $debugMode): self;

    public function getQueryKey(): ?string;

    public function setQueryKey(?string $queryKey): self;

    public function getCreatedByUser(): ?string;

    public function setCreatedByUser(?string $createdByUser): self;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(?string $createdAt): self;

    public function getUpdatedAt(): ?string;

    public function setUpdatedAt(?string $updatedAt): self;
}
