<?php 

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Extension extends AbstractExtension {
    /**
     * COURS : 
     * - On utilise l'injection de dépendance pour utiliser les classes appelés Services dans Symfony
     * - La classe ParameterBagInterface va permettre de récupérer les valeurs des paramètres du projet 
     *   (déclarés dans config/services.yaml )
     */
    private $parametres;

    public function __construct(ParameterBagInterface $parameters)
    {
        $this->parametres = $parameters;
    }

    /**
     * J'écris le filtre que je veux ajouter comme n'importe quelle fonction
     */
    public function autorisations(array $roles): string
    {
        $autorisations = "";
        foreach ($this->roles as $role ) {
            $autorisations .= $autorisations ? ", " : "";
            switch ($role) {
                case 'ROLE_ADMIN':
                    $autorisations .= "Directeur";
                    break;
                
                case 'ROLE_BIBLIO':
                    $autorisations .= "Bibliothécaire";
                    break;
                
                case 'ROLE_LECTEUR':
                    $autorisations .= "Lecteur";
                    break;
                
                case 'ROLE_USER':
                    $autorisations .= "Abonné";
                    break;

                case 'ROLE_DEV':
                    $autorisations .= "Développeur";
                    break;
                
                default:
                    $autorisations .= "Autre";
                    break;
            }
        }
        return $autorisations;
    }

    /**
     * Cette méthode va renvoyer une balise image.
     * @param $nomImage string nom du fichier image. L'image sera recherché à partir du 'chemin_image' défini 
     */
    public function baliseImg($nomImage, $dossier = "", $classes = "", $alt = "") : string
    {
        $balise = "";
        if($dossier && substr($dossier, -1) != "/"){
            $dossier .= "/";    // 🎶 ajoute un "/" en fin de $dossier s'il n'y en a pas déjà
        }
        $src =  $this->parametres->get("chemin_images") . $dossier .  $nomImage;
        $alt = $alt ?: $nomImage;
        $balise = "<img src='$src' class='$classes' alt='$alt'>";
        // $balise = html_entity_decode($balise); // COURS obligatoire pour que twig accepte les balises HTML. ⚠ il faut utiliser 'raw'
        return $balise;
    }

    /**
     * Je référence le nouveau filtre grâce à la méthode getFilters()
     * Si je veux ajouter une fonction, j'utilise la méthode getFunctions() et
     * pour ajouter un test, getTests()
     */
    public function getFilters()
    {
        return [ 
            new TwigFilter("autorisations", [$this, "autorisations"]),
            new TwigFilter('img', [$this, 'baliseImg']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('balise_image', [$this, 'baliseImg']),
        ];
    }

}