<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;

/**
 * @extends FactoryInterface<Application>
 */
interface ApplicationFactoryInterface extends FactoryInterface
{
    public function createNew(): Application;
}
