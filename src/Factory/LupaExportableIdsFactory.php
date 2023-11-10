<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIds;

class LupaExportableIdsFactory implements LupaExportableIdsFactoryInterface
{
    public function createNew(): LupaExportableIds
    {
        return new LupaExportableIds();
    }
}
