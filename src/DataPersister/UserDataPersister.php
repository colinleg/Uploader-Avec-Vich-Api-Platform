<?php

    namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface{

        public function __construct(
            private EntityManagerInterface $em,

        ){}

        public function supports($data, array $context = []): bool
        {
            // if($context)
            return true;
        }

        public function persist($data, array $context = [])
        {
            
        }

        public function remove($data, array $context = [])
        {
            
        }
}