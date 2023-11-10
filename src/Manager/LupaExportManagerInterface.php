<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager;

/**
 * @template T of object
 */
interface LupaExportManagerInterface
{
    public function supports(object $object): bool;

    /**
     * @param T $object
     */
    public function export(object $object): void;

    /**
     * @param T $object
     */
    public function delete(object $object): void;
}
