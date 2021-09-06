<?php

    namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

final class PhotosNormalizer implements ContextAwareNormalizerInterface, NormalizerInterface{

    public function __construct(
        StorageInterface $storageInterface
    )
    {}

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
         return true;
    }

    public function normalize($object, ?string $format = null, array $context = [])
    {
        dd($object, $format, $context);

        $object->contentUrl = $this->storage->resolveUri($object, 'file');

        return $this->normalizer->normalize($object, $format, $context);
    }
}