<?php

namespace App\Serializer;

use App\Entity\Room;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class RoomObjectNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        private StorageInterface $storage,
        private CacheManager $imagineCacheManager,
    ) {
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Room;
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        $object->imageUrl = $this->resolveCacheImageUrl($object, 'imageFile', 'profile');
        $object->avatarUrl = $this->resolveCacheImageUrl($object, 'avatarFile', 'avatar');

        return $this->normalizer->normalize($object, $format, $context);
    }

    private function resolveCacheImageUrl(mixed $object, string $fieldName, string $filter): ?string
    {
        $relativePath = $this->storage->resolveUri($object, $fieldName);

        if (!$relativePath) {
            return null;
        }

        return $this->imagineCacheManager->generateUrl($relativePath, $filter, referenceType: UrlGeneratorInterface::ABSOLUTE_PATH);
    }
}
