<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIds;

interface LupaExportableIdsFactoryInterface
{
    public function createNew(): LupaExportableIds;
}
