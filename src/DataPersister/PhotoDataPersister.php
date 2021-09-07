<?php

    namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Photos;
use Doctrine\ORM\EntityManagerInterface;

class PhotoDataPersister implements ContextAwareDataPersisterInterface{

        public function __construct(
            private EntityManagerInterface $em,

        ){}

        public function supports($data, array $context = []): bool
        {
            if($data instanceof Photos){
                return true;
            }
            else{
                return false;
            }
        }

        public function persist($data, array $context = [])
        {

            $photo = $data;
            // dd($photo);

            # todo : recuperer le nom de l'user pour le naming personnalisé
            $photo->setImageName('image_truc');

            $this->em->persist($photo);
            $this->em-> flush();

            return $photo;
            
        }

        public function remove($data, array $context = [])
        {
            
        }
}