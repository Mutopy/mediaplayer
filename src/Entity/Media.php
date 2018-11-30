<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $extension;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="medias")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Genre", inversedBy="medias")
     */
    private $genre;

    private $image;

    private $file;

    /**
     * @return mixed
     */
    public function getImage()
    {
        if ($this->getPicture()!= null){
            $this->image = new File('C:\wamp64\www\mediaplayer\public\medias\\'.$this->getPicture());
            dump($this->image);
        }
        return  $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $nameMedia = $image->getClientOriginalName();
        $image->move( 'C:\wamp64\www\mediaplayer\public\medias', $nameMedia);
        $this->setPicture($nameMedia);
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        if($this->getName() != null) {
            $this->file = new File('C:\wamp64\www\mediaplayer\public\medias\\'.$this->getPicture());
            dump($this->file);
        }
        return  $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $nameMedia = $file->getClientOriginalName();
        $file->move( 'C:\wamp64\www\mediaplayer\public\medias', $nameMedia);
        $this->setName(explode(".",$nameMedia)[0]);
        $this->setExtension(explode(".",$nameMedia)[1]);
        $this->file = $file;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

}
