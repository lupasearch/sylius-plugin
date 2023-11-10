<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class InterfaceDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return $this->denormalizer->denormalize(
            $data,
            (string) $this->getClass($type),
            $format,
            $context,
        );
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return (bool) $this->getClass($type);
    }

    private function getClass(string $interface): ?string
    {
        $isArray = $this->isArray($interface);

        $interface = $this->cleanInterface($interface);
        if (!str_ends_with($interface, 'Interface')) {
            return null;
        }

        if (!interface_exists($interface)) {
            return null;
        }

        $class = str_replace('Interface', '', $interface);
        if (!class_exists($class)) {
            return null;
        }

        if (!is_a($class, $interface, true)) {
            return null;
        }

        return $class . ($isArray ? '[]' : '');
    }

    private function isArray(string $interface): bool
    {
        return str_ends_with($interface, '[]');
    }

    private function cleanInterface(string $interface): string
    {
        return str_replace('[]', '', $interface);
    }
}
