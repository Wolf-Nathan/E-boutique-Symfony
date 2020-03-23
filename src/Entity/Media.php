<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jeux", inversedBy="media")
     */
    private $jeux;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Console", inversedBy="media")
     */
    private $console;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ConsoleModele", inversedBy="media")
     */
    private $ConsoleModele;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="media")
     */
    private $marque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getJeux(): ?Jeux
    {
        return $this->jeux;
    }

    public function setJeux(?Jeux $jeux): self
    {
        $this->jeux = $jeux;

        return $this;
    }

    public function getConsole(): ?Console
    {
        return $this->console;
    }

    public function setConsole(?Console $console): self
    {
        $this->console = $console;

        return $this;
    }

    public function getConsoleModele(): ?ConsoleModele
    {
        return $this->ConsoleModele;
    }

    public function setConsoleModele(?ConsoleModele $ConsoleModele): self
    {
        $this->ConsoleModele = $ConsoleModele;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }
}
