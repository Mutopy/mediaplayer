<?php
/**
 * Created by PhpStorm.
 * User: maliaga2018
 * Date: 27/11/2018
 * Time: 13:46
 */

namespace App\Entity;


use Symfony\Component\HttpFoundation\File\File;

class Fichier
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }


    public function setFile(File $myFile = null) {
        $this->file = $myFile;
    }

    public function getFile() {
        return $this->file;
    }

    public function getName() {
        return $this->file->getClientOriginalName();
    }

    public function upload($targetDirectory)
    {
        //$fileName = md5(uniqid()).'.'.$this->file->guessExtension();
        $fileName = $this->getName();

        $this->file->move($targetDirectory, $fileName);

        return $fileName;
    }
}