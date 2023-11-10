<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

class Document implements DocumentInterface
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $code = null;

    private ?string $variantCode = null;

    private ?string $slug = null;

    private ?string $mainImage = null;

    /** @var array<string, mixed> */
    private array $attributes = [];

    /** @var string[] */
    private array $taxonCodes = [];

    private ?string $mainTaxonCode = null;

    private ?string $productId = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getVariantCode(): ?string
    {
        return $this->variantCode;
    }

    public function setVariantCode(?string $variantCode): self
    {
        $this->variantCode = $variantCode;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->mainImage;
    }

    public function setMainImage(?string $mainImage): self
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function addAttribute(string $code, string $value): self
    {
        $this->attributes[$code] = $value;

        return $this;
    }

    public function getTaxonCodes(): array
    {
        return $this->taxonCodes;
    }

    public function setTaxonCodes(array $taxonCodes): self
    {
        $this->taxonCodes = $taxonCodes;

        return $this;
    }

    public function getMainTaxonCode(): ?string
    {
        return $this->mainTaxonCode;
    }

    public function setMainTaxonCode(?string $mainTaxonCode): self
    {
        $this->mainTaxonCode = $mainTaxonCode;

        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): self
    {
        $this->productId = $productId;

        return $this;
    }
}
