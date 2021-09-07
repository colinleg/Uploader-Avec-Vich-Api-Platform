<?php
    namespace App\Naming;

use App\Entity\Photos;
use App\Entity\User;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\UniqidNamer;

class AvatarNameNamer implements NamerInterface{

    public function __construct(
        # Ce namer peut être utilisé par défaut dans config/package/vich_upload... 
        private UniqidNamer $unique
    )
    {}


    public function name($object, PropertyMapping $mapping): string
    {
        # Lors des opérations 'new_user' et 'new_user_photos', on attribue au fichier
        # un nom de type : avatar_of_jean_dupont_2vfdvfvd.jpg 
        if($object instanceof User){

            $prenom = $object->getPrenom();
            $nom = $object->getNom();
            $filename = $object->getAvatar()->getFilename();

            $unique = $this->unique->name($object, $mapping);
            $finalName = 'avatar_of_' . $prenom . '_' . $nom . '_' . $filename . $unique ;
        
            return $finalName;
        }
        
        # Lors de l'opération 'upload', on attribue au fichier un id unique
        if($object instanceof Photos){
            $unique = $this->unique->name($object, $mapping);
            return $unique;
        }
    }

}