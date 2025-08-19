<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface LupaExportableIdsInterface extends ResourceInterface
{
    public function getIdToAdd(): ?int;

    public function setIdToAdd(?int $idToAdd): LupaExportableIds;

    public function getIdToRemove(): ?int;

    public function setIdToRemove(?int $idToRemove): LupaExportableIds;
}
