<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EventService
{
    private $manager;
    private $directory;

    public function __construct(EntityManagerInterface $manager, $directory)
    {
        $this->manager = $manager;
        $this->directory = $directory;
    }

    public function upload(UploadedFile $file)
    {
        $filename = uniqid().'.'.$file->guessExtension();
        // Upload du fichier
        $file->move($this->directory, $filename);

        return $filename;
    }
}
