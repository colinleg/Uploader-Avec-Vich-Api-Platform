<?php

    namespace App\DataPersister;

use App\Entity\User;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

class UserPhotoDataPersister implements ContextAwareDataPersisterInterface{

    public function __construct(
        private EntityManagerInterface $em,
        private StorageInterface $storage,

    )
    {}

    public function supports($data, array $context = []): bool
    {
        
        if($data instanceof User && $context['collection_operation_name'] === 'new_user_photos'){
            return true; 
        }

        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        

        $this->em->persist($data);
        $this->em->flush();

        $avatarUrl = $this->storage->resolveUri($data,'avatar', 'App\Entity\User');
        $data->setAvatarUrl($avatarUrl);

        return $data;
    }

    public function remove($data, array $context = [])
    {
        
    }
}