<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Messenger\Command;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIdsInterface;

class ExportToLupa
{
    /** @var LupaExportableIdsInterface[] */
    public array $lupaExportableIds = [];

    /**
     * @param LupaExportableIdsInterface[] $lupaExportableIds
     */
    public function __construct(array $lupaExportableIds)
    {
        $this->lupaExportableIds = $lupaExportableIds;
    }

    /**
     * @return LupaExportableIdsInterface[]
     */
    public function getLupaExportableIds(): array
    {
        return $this->lupaExportableIds;
    }
}
