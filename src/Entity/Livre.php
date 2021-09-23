<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreRepository;
use App\EventListener\LivreListener;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 * @ORM\EntityListeners({LivreListener::class})
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couverture;

    /**
     * COURS : pour que le formulaire Livre qui utilise un formulaire Categorie enregistre des nouvelles 
     *          catégories en même temps qu'un nouveau livre
     * @ORM\ManyToMany(targetEntity=Categorie::class, inversedBy="livres",cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Emprunt::class, mappedBy="livre", orphanRemoval=true)
     */
    private $emprunts;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection|Emprunt[]
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts[] = $emprunt;
            $emprunt->setLivre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLivre() === $this) {
                $emprunt->setLivre(null);
            }
        }

        return $this;
    }

    /* Dans la bdd, le seul moyen de savoir si un livre est indisponible 
        c'est en regardant les enregistrements de la table Emprunt dont la
        date_retour est null. 
        Je vais rajouter une propriété à la classe Livre, mais cette propriété
        ne  crééra pas de champ dans la base de donnée (=pas d'annotations)

        Pour affecter une valeur à cette propriété, je vais utiliser la méthode
        LivreRepository::findLivresSortis mais je ne peux pas instancier une classe Repository
        il faut utiliser l'injection de dépendance dans un contrôleur.
        Alors, je vais utiliser la technique des écouteurs d'évènements
        cf : App/EventListener/LivreListener
    */
    private $dispo;
    
    public function getDispo()
    {
        return $this->dispo;
    }
    public function setDispo(bool $dispo)
    {
        $this->dispo = $dispo;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture(?string $couverture): self
    {
        $this->couverture = $couverture;

        return $this;
    }
}
