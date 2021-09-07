<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Vich\UploaderBundle\Storage\StorageInterface;

class UserPhotoController extends AbstractController
{
    public function __invoke(
        Request $request,
        StorageInterface $storageInterface
    ){
        $user = new User();

        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');

        $file = $request->files->get('photo');

        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setAvatar($file);
       
        
        $user->setAvatarUrl($storageInterface->resolveUri($user,'avatar','App\Entity\User'));


        return $user;
    }
}
