<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\UploadController;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 * @Vich\Uploadable
 * 
 */
#[ApiResource(
    
    itemOperations: [
        'get' => [
            'openapi_context' => [
                'summary' => 'Ne pas supprimer : utilisé par Api Platform'
            ]
        ]
    ],
    collectionOperations: [
        # cheminement custom : UploadController -> AvatarNameNamer -> PhotoDataPersister
        # correspond à "Uploader une image" dans la partie front
        'upload' => [
            'method' => 'post',
            'path' => '/photos/upload',
            'controller' => UploadController::class,
            'deserialize' => false,
            'validate' => false,
            'openapi_context' => [
                'summary' => 'Uploader une image',
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'photos' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
         ]
    ]
)]
class Photos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @var File|null remarque : ce n'est pas une column Doctrine
     * @Vich\UploadableField(mapping="photos", fileNameProperty="imageName")
     */
    private ?File $imageFile;

    /**
    * Dernier Update
    *
    * @ORM\Column(type="datetime")
    * @var \DatetimeInterface|null
    */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
    * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
    * of 'UploadedFile' is injected into this setter to trigger the update. If this
    * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
    * must be able to accept an instance of 'File' as the bundle will inject one here
    * during Doctrine hydration.
    *
    * Une astuce de symfony pour contourner le updatedAt ? 
    *
    * @param File $imageFile
    */
    public function setImageFile(?File $imageFile = null) : void
    {
        $this->imageFile = $imageFile;

        if(null !== $imageFile){
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(DateTime $dateTime){
        $this->updatedAt = $dateTime;
    }
    
}
