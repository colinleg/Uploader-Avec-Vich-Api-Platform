<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Service\UploadService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UploadController extends AbstractController
{
    // #[Route('/upload', name: 'upload')]
    // public function index(): Response
    // {
    //     return $this->render('upload/index.html.twig', [
    //         'controller_name' => 'UploadController',
    //     ]);
    // }

    public function __invoke(
        Request $request,
        // UploadService $uploadService
    )
    {
        // dd($request);

        // $photo = $request->files->get('photo');
        // $photo = $request->attributes->get('data');
        // $photo = $request->files->get('photo');
        // $directory = $this->getParameter('images_directory');
        // $uploadService->upload($photo, $directory);

        $file = $request->files->get('photos');

        if(!$file){
            throw new BadRequestHttpException('"file" is required');
        }

        $photos = new Photos();
        $photos->file = $file;

        return $photos;
    }
}
