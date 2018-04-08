<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BiensRepository")
 */
class Biens
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $NomBien;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Etat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="integer", length=20)
     */
    private $Prix;

    /**
     * @ORM\ManyToOne(
     * targetEntity="App\Entity\Localite")
     * @ORM\JoinColumn(nullable=false)
     */
    private $localite;
    
    /**
     * @ORM\ManyToOne(
     * targetEntity="App\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(
     * targetEntity="App\Entity\Proprietaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Proprietaire;



    public function getId()
    {
        return $this->id;
    }

    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getNomBien(): ?string
    {
        return $this->NomBien;
    }

    public function setNomBien(string $NomBien): self
    {
        $this->NomBien = $NomBien;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->Etat;
    }

    public function setEtat(bool $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }
}
