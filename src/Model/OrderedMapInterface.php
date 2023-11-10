<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Model;

use IteratorAggregate;

/**
 * @extends IteratorAggregate<string, int|float|bool|string|OrderedMapInterface|mixed>
 */
interface OrderedMapInterface extends IteratorAggregate
{
    /**
     * @param int|float|bool|string|OrderedMapInterface|mixed $value
     */
    public function add(string $name, $value): self;

    public function remove(string $name): self;

    /**
     * @return mixed
     */
    public function get(string $name);

    public function isEmpty(): bool;
}
