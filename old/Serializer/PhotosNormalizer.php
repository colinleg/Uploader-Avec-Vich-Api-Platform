<?php

    namespace App\Serializer;

    # Note : Normaliser consiste à transformer un objet (ici Php en un tableau)
    #       Ici on reçoit un object App\Entity\Photos de la part du controller (UploadController::class)

use App\Entity\Photos;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;


final class PhotosNormalizer implements ContextAwareNormalizerInterface, NormalizerInterface{

    # Le Trait contient la variable $normalizer, qui est instance de NormalizerInterface
    use NormalizerAwareTrait;

    // private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    # Notes : La Storage Interface a 5 méthodes :

    #   upload( $obj, PropertyMapping $mapping)
    #   remove($obj, PropertyMapping $mapping)
    #   resolvePath($obj, ?string $fieldName = null, ?string $className = null, ?bool $relative = false): ?string
    #   resolveUri($obj, ?string $fieldName = null, ?string $className = null): ?string
    #   resolveStream($obj, string $fieldName, ?string $className = null)

    #   On utilise ici la méthode resolveUri(). Qui permet de résoudre un Uri.

    # Rappel : Uri = Uniform Ressource Identifier. Un élément permettant d'identifier une ressource.
    # serait de la forme file://host/path

    public function __construct(
        private StorageInterface $storage
    )
    {}

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        // if (isset($context[self::ALREADY_CALLED])) {
        //     return false;
        // }

        // dd($data, $format, $context);

        # ici format = json c'est à dire qu'on cherche à créer un tableau json
        # $data = object de type OpenApi
        # pas de context

        return $data instanceof Photos;
        // return true;
    }

    public function normalize($object, ?string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        // dd($object, $format, $context);

        # La méthode resolveUri() prend en params:
        
        #   un object : ici de type App\Entity\Photos
        #   le champ de l'objet qui sera utilisé pour stocker L'Uri : ici le champ 'file' d'un object Photos
        #   Optionnel : la classe de l'objet, sous forme de string.
        
        $object->contentUrl = $this->storage->resolveUri($object, 'imageName');

        return $this->normalizer->normalize($object, $format, $context);
    }
}