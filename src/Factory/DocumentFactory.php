<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\Document;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;

class DocumentFactory implements DocumentFactoryInterface
{
    public function createNew(): DocumentInterface
    {
        return new Document();
    }
}
