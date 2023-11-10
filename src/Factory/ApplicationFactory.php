<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;

class ApplicationFactory implements ApplicationFactoryInterface
{
    public function __construct(private readonly KernelInterface $kernel)
    {
    }

    public function createNew(): Application
    {
        return new Application($this->kernel);
    }
}
