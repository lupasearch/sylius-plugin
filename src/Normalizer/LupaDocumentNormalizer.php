<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Normalizer;

use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Webmozart\Assert\Assert;

use function array_merge;
use function in_array;
use function is_array;

class LupaDocumentNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = self::class . '-already-called';

    /**
     * @inheritDoc
     *
     * @param DocumentInterface|mixed $object
     *
     * @throws ExceptionInterface
     */
    public function normalize($object, ?string $format = null, array $context = []): mixed
    {
        Assert::isInstanceOf($object, DocumentInterface::class);
        Assert::false(
            $context[self::ALREADY_CALLED] ?? false,
            'Circular dependency detected while normalizing object of class"' . get_class($object) . '".',
        );
        $context[self::ALREADY_CALLED] = true;

        $normalizedDocument = $this->normalizer->normalize($object, $format, $context);
        if (!is_array($normalizedDocument)) {
            return $normalizedDocument;
        }

        $group = $this->getGroup($object);
        if (!$group) {
            return $normalizedDocument;
        }

        if (!in_array($group, (array) ($context['groups'] ?? []), true)) {
            return $normalizedDocument;
        }

        $normalizedAttributes = $this->normalizer->normalize($object->getAttributes(), $format, $context);
        if (!is_array($normalizedAttributes)) {
            return $normalizedDocument;
        }

        return array_merge(
            $normalizedDocument,
            $normalizedAttributes,
        );
    }

    /**
     * @param mixed $data
     *
     * @inheritDoc
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return !($context[self::ALREADY_CALLED] ?? false) && $data instanceof DocumentInterface;
    }

    private function getGroup(DocumentInterface $document): ?string
    {
        return 'lupasearch:document:read';
    }
}
