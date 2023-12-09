<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;

/**
 * @ORM\Entity(repositoryClass=EmpruntRepository::class)
 */
class Emprunt extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @LessThan(propertyPath= "dateRetour",  message= "La date d'emprunt doit être antérieure" )
     */
    #[LessThan( propertyPath: "dateRetour",  message: "La date d'emprunt doit être antérieure" )]

    private $dateEmprunt;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @GreaterThan(propertyPath= "dateEmprunt", message= "La date retour doit être postérieure")
     */
    #[GreaterThan(propertyPath: "dateEmprunt", message: "La date retour doit être postérieure")]
    private $dateRetour;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="emprunts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livre;

    /**
     * @ORM\ManyToOne(targetEntity=Abonne::class, inversedBy="emprunts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $abonne;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_prevue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): self
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->dateRetour;
    }

    public function setDateRetour(?\DateTimeInterface $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getAbonne(): ?Abonne
    {
        return $this->abonne;
    }

    public function setAbonne(?Abonne $abonne): self
    {
        $this->abonne = $abonne;

        return $this;
    }

    public function getDatePrevue(): ?\DateTimeInterface
    {
        return $this->date_prevue;
    }

    public function setDatePrevue(?\DateTimeInterface $date_prevue): self
    {
        $this->date_prevue = $date_prevue;

        return $this;
    }
}
