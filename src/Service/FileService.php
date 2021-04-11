<?php

namespace App\Service;

use App\Entity\Animal\Animal;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileService
{
    const BASE_DIR = 'upload/';

    /** @var SluggerInterface  */
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * @param $file
     * @param string $directory
     * @return mixed
     */
    public function addNewFile($file, $directory = ''): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename  = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        $file->move(
            self::BASE_DIR.$directory,
            $newFilename
        );

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents
        return $newFilename;
    }

    /**
     * @param Animal $animal
     * @param $type
     */
    public function addAnimalImages(Animal $animal, $type)
    {
        $images = [];
        /** @var UploadedFile $image */
        foreach ($animal->getImages() as $image) {
            $newPath = $this->addNewFile($image, 'animal/'.$type);
            $images[] = $newPath;
        }
        $animal->setImages($images);
    }
}