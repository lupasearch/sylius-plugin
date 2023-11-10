<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\InitiateExportToLupa;

class InitiateExportToLupaFactory implements InitiateExportToLupaFactoryInterface
{
    public function createNew(): InitiateExportToLupa
    {
        return new InitiateExportToLupa();
    }
}
