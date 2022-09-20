<?php

namespace App\Service;

use App\Entity\Animal\Animal;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileService
{
    const BASE_DIR = 'upload/';

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function addNewFile(UploadedFile $file, string $directory = ''): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move(
            self::BASE_DIR . $directory,
            $newFilename
        );

        return $newFilename;
    }

    public function addAnimalImages(Animal $animal, string $type): Animal
    {
        $images = [];

        /** @var UploadedFile $image */
        foreach ($animal->getImages() as $image) {
            $newPath = $this->addNewFile($image, 'animal/' . $type);
            $images[] = $newPath;
        }
        $animal->setImages($images);

        return $animal;
    }
}