<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

final class LupaSearchSyliusLupaSearchPlugin extends AbstractResourceBundle
{
    use SyliusPluginTrait;

    protected string $mappingFormat = self::MAPPING_YAML;

    /**
     * @return string[]
     */
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    protected function getModelNamespace(): string
    {
        return 'LupaSearch\SyliusLupaSearchPlugin\Entity';
    }
}
