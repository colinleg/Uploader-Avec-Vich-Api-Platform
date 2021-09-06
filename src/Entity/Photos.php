<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\UploadController;
use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PhotosRepository::class)
 * @Vich\Uploadable()
 */
#[ApiResource(
    collectionOperations: [
        'upload' => [
            'controller' => UploadController::class,
            'deserialize' => false, 
            'validate' => false,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
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
     * Undocumented variable
     *
     * @Vich\UploadableField(mapping="photos", FileNameProperty="filePath")
     */
    public ?File $file;

    /**
     * @ORM\Column(nullable=true)
     */
    public $filePath = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    
}
