<?php

namespace App\Controller;

use App\Entity\Photos;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class UploadController extends AbstractController
{

    public function __invoke(
        Request $request,
    ) : Photos
    {
        

        # Ici, on a un objet de type Symfony\Component\HttpFoundation\File\UploadedFile
        # où le mimeType est de type : "application/octet-stream"
        $file = $request->files->get('photos');
        // $file = $request->attributes->get('photos');
        // dd($file);
        if(!$file){
            throw new BadRequestHttpException('"photos" is required');
        }

        $photos = new Photos();
        // $photos->file = $file;
        $photos->setImageFile($file);
        $photos->setUpdatedAt(new \DateTime());
        
        // dd($photos);

        # on retourne un objet de type App\Entity\Photos,
        # qui n'a ni id, ni contentUrl, ni filePath
        # mais seulement un object de type UploadedFile dans son champ ' +file '

        // dd($photos);
        return $photos;
    }
}
