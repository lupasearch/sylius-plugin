<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Normalizer;

use LupaSearch\SyliusLupaSearchPlugin\Factory\OrderedMapFactoryInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\OrderedMapInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Webmozart\Assert\Assert;

class LupaSearchOrderedMapDenormalizer implements DenormalizerInterface
{
    public function __construct(private readonly OrderedMapFactoryInterface $orderedMapFactory)
    {
    }

    public function denormalize($data, string $type, string $format = null, array $context = []): OrderedMapInterface
    {
        $map = $this->orderedMapFactory->createNew();
        if (null === $data) {
            return $map;
        }

        Assert::isIterable($data);
        foreach ($data as $name => $value) {
            $value = is_scalar($value) ? $value : $this->denormalize($value, $type, $format, $context);

            $map->add((string) $name, $value);
        }

        return $map;
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return is_a($type, OrderedMapInterface::class, true);
    }
}
