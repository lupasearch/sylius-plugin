<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Normalizer;

use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmozart\Assert\Assert;

class LupaDocumentsNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param DocumentsInterface|mixed $object
     *
     * @return array<string, mixed>
     *
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        Assert::isInstanceOf($object, DocumentsInterface::class);

        $normalizedDocuments = [];

        /** @var DocumentInterface $document */
        foreach ($object as $document) {
            /** @var array<string, mixed> $normalizedDocument */
            $normalizedDocument = $this->normalizer->normalize($document, $format, $context);
            /** @var array<string, mixed> $normalizedAttributes */
            $normalizedAttributes = $this->normalizer->normalize($document->getAttributes(), $format, $context);

            $normalizedDocuments[] = array_merge(
                $normalizedDocument,
                $normalizedAttributes,
            );
        }

        return [
            'documents' => $normalizedDocuments,
            'finished' => $object->isFinished(),
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof DocumentsInterface;
    }
}
