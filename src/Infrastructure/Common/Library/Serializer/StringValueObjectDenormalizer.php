<?php

namespace App\Infrastructure\Common\Library\Serializer;

use App\Application\Common\Domain\ValueObject\StringValueObjectInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class StringValueObjectDenormalizer implements DenormalizerInterface
{
    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return is_a($type, StringValueObjectInterface::class, true);
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): object {
        if (is_array($data) && array_key_exists('value', $data)) {
            $data = $data['value'];
        }

        if (!is_string($data)) {
            throw new NotNormalizableValueException(sprintf('%s must be a string', $type));
        }

        /** @var class-string<StringValueObjectInterface> $type */
        return $type::fromString(
            trim($data),
        );
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
