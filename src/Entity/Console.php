<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsoleRepository")
 */
class Console
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="consoles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConsoleModele", mappedBy="console")
     */
    private $consoleModeles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Jeux", mappedBy="console")
     */
    private $jeux;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Media", mappedBy="console")
     */
    private $media;

    public function __construct()
    {
        $this->consoleModeles = new ArrayCollection();
        $this->jeux = new ArrayCollection();
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    /**
     * @return Collection|ConsoleModele[]
     */
    public function getConsoleModeles(): Collection
    {
        return $this->consoleModeles;
    }

    public function addConsoleModele(ConsoleModele $consoleModele): self
    {
        if (!$this->consoleModeles->contains($consoleModele)) {
            $this->consoleModeles[] = $consoleModele;
            $consoleModele->setConsole($this);
        }

        return $this;
    }

    public function removeConsoleModele(ConsoleModele $consoleModele): self
    {
        if ($this->consoleModeles->contains($consoleModele)) {
            $this->consoleModeles->removeElement($consoleModele);
            // set the owning side to null (unless already changed)
            if ($consoleModele->getConsole() === $this) {
                $consoleModele->setConsole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Jeux[]
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeux(Jeux $jeux): self
    {
        if (!$this->jeux->contains($jeux)) {
            $this->jeux[] = $jeux;
            $jeux->addConsole($this);
        }

        return $this;
    }

    public function removeJeux(Jeux $jeux): self
    {
        if ($this->jeux->contains($jeux)) {
            $this->jeux->removeElement($jeux);
            $jeux->removeConsole($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->setConsole($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->contains($medium)) {
            $this->media->removeElement($medium);
            // set the owning side to null (unless already changed)
            if ($medium->getConsole() === $this) {
                $medium->setConsole(null);
            }
        }

        return $this;
    }
}
