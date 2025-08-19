<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Entity;

class LupaExportableIds implements LupaExportableIdsInterface
{
    private ?int $id = null;

    private ?int $idToAdd = null;

    private ?int $idToRemove = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdToAdd(): ?int
    {
        return $this->idToAdd;
    }

    public function setIdToAdd(?int $idToAdd): self
    {
        $this->idToAdd = $idToAdd;

        return $this;
    }

    public function getIdToRemove(): ?int
    {
        return $this->idToRemove;
    }

    public function setIdToRemove(?int $idToRemove): self
    {
        $this->idToRemove = $idToRemove;

        return $this;
    }
}
