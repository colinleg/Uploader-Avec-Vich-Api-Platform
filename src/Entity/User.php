<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'new_user' => [
            'method' => 'post',
            'openapi_context' => [
                'summary' => 'Ajoute un user avec le l\'url de sa photo',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'nom' =>  [
                                        'type' => 'string',
                                        'example' => 'Tran'
                                    ],
                                    'prenom' => [
                                        'type' => 'string',
                                        'example' => 'Hugo'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'upload_photo' => [
            'method' => 'post',
            'path' => '/upload',
            'deserialize' => false,
            'controller' => UploadController::class
            // 'openapi_context' => 
        ]
    ],
    itemOperations: ['get']
)]
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }
}
