<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

interface DocumentInterface
{
    public function getId(): ?string;

    public function setId(?string $id): self;

    public function getName(): ?string;

    public function setName(?string $name): self;

    public function getCode(): ?string;

    public function setCode(?string $code): self;

    public function getVariantCode(): ?string;

    public function setVariantCode(?string $variantCode): self;

    public function getSlug(): ?string;

    public function setSlug(?string $slug): self;

    public function getMainImage(): ?string;

    public function setMainImage(?string $mainImage): self;

    /**
     * @return array<string, mixed>
     */
    public function getAttributes(): array;

    public function addAttribute(string $code, string $value): self;

    /**
     * @return string[]
     */
    public function getTaxonCodes(): array;

    /**
     * @param string[] $taxonCodes
     */
    public function setTaxonCodes(array $taxonCodes): self;

    public function getMainTaxonCode(): ?string;

    public function setMainTaxonCode(?string $mainTaxonCode): self;

    public function getProductId(): ?string;

    public function setProductId(?string $productId): self;

    public function getProductName(): ?string;

    public function setProductName(?string $productName): self;

    public function getProductMainImage(): ?string;

    public function setProductMainImage(?string $productMainImage): self;
}
