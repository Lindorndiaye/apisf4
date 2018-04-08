<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationsRepository")
 */
class Reservations
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
    private $DateDeReservation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Etat;

    /**
     * @ORM\ManyToOne(
     * targetEntity="App\Entity\Biens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Biens;

    /**
     * @ORM\ManyToOne(
     * targetEntity="App\Entity\Clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Client;

    public function getId()
    {
        return $this->id;
    }

    public function getDateDeReservation(): ?string
    {
        return $this->DateDeReservation;
    }

    public function setDateDeReservation(string $DateDeReservation): self
    {
        $this->DateDeReservation = $DateDeReservation;

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
}
