<?php

namespace App\MesServices;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageServices
{
    protected $slugger;
    protected $parameterBag;

    public function __construct(SluggerInterface $slugger,ParameterBagInterface $parameterBag)
    {
        $this->slugger = $slugger; 
        $this->parameterBag = $parameterBag;
    }


    public function sauvegarderImage(object $object, object $file)
    {
        // Je transforme le nom du fichier

        $originialName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = this->$slugger->slug($originalName);
        $uniqFileName = $safeName . '-' . uniqid() . '.' . $file->guessExtension();

        // Je met le fichier dans le dossier uploads
        $file->move(
            $this->parameterBag->get('app_images_directory'),
            $uniqFileName
        );

        $object->setImage('uploads/' . $uniqFileName);
    }


    // Pour pouvoir supprimer une image 
    
    public function supprimerImage(string $fileName)
    {
        $pathFile = $this->parameterBag->get('app_images_directory') . '/..' . $fileName; 

        if(file_exists($pathFile))
        {
            unlink($pathFile);
        }
    }
}