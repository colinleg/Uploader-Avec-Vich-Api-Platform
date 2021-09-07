<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\UserPhotoController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 */
#[ApiResource(
    // normalizationContext: ['groups' => ['new_user_photos:return']],
    collectionOperations: [

        # Création d'un user avec une photo 'null'. Correspond à
        # 'inscription sans image ( chemin : / )' dans le front.
        # cheminement par défaut d'Api Platform
        'new_user' => [
            'method' => 'post',
            'normalization_context' => ['groups' => ['new_user:return']],
            'openapi_context' => [
                'summary' => 'Ajoute un simple user',
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

        # Création d'un user avec avatar. Correspond à 
        # '/inscription' dans la partie front.
        # cheminement custom : UserPhotoController -> AvatarNameNamer -> UserPhotoDataPersister -> NormalizationGroups
        'new_user_photos' => [
            'method' => 'post',
            'path' => '/users/avatar',
            'controller' => UserPhotoController::class,
            'deserialize' => false,
            'normalization_context' => ['groups' => ['new_user_photos:return']],
            'openapi_context' => [
                'summary' => 'Ajouter un user avec son avatar',
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                        'nom' => [
                                            'type' => 'string'
                                        ],
                                        'prenom' => [
                                            'type' => 'string'
                                        ],
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
    ],
    itemOperations: [
        'get' => [
            'openapi_context' => [
                'summary' => 'Ne pas supprimer : utilisé par Api Platform'
            ]
        ]
    ]
)]
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['new_user_photos:return', 'new_user:return'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['new_user_photos:return', 'new_user:return'])]
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['new_user_photos:return', 'new_user:return'])]
    private $Prenom;

    /**
     *  Le fichier lui-meme
     *
     * @Vich\UploadableField(mapping="photos", fileNameProperty="avatarName")
     * @var File|null
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['new_user_photos:return'])]
    private $avatarUrl;



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

    public function getAvatarName(): ?string
    {
        return $this->avatarName;
    }

    public function setAvatarName(?string $avatarName): self
    {
        $this->avatarName = $avatarName;

        return $this;
    }

    public function setAvatar(File $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getAvatar(): ?File   
    {
        return $this->avatar;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

}
