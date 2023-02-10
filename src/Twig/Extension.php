<?php 

namespace App\Twig;

use Twig\TwigFilter;
use App\Entity\Abonne;
use App\Entity\Client;
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

    public function salut(Abonne $abonne, $auj = null)
    {
        $salutations = "Bonjour ";
        if( !empty($abonne->getPrenom()) || !empty($abonne->getNom()) ){
            $salutations .= $abonne->getPrenom() . " " . $abonne->getNom();
        } else {
            $salutations .= $abonne->getPseudo();
        }
        $salutations .= ", nous sommes le ";
        $auj = $auj ?? (new \DateTime())->format("d/m/Y");
        $salutations .= $auj;
        return $salutations;
    }

    /**
     * J'écris le filtre que je veux ajouter comme n'importe quelle fonction
     */
    public function autorisations(array $roles): string
    {
        $autorisations = "";
        foreach ($roles as $role ) {
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
    public function accreditations(Abonne $client)
    {
        $autorisations = "";
        foreach( $client->getRoles() as $role){
            $autorisations .= $autorisations ? ", " : "";
            switch ($role) {
                case 'ROLE_ADMIN':
                    $autorisations .= "Gérant";
                    break;
                
                case 'ROLE_VENDEUR':
                    $autorisations .= "Vendeur";
                    break;
                
                default:
                    $autorisations .= "Membre";
                    break;
            }
        }
        return $autorisations;
    }

    public function resume(string $texte, int $longueur)
    {
        return strlen($texte) > $longueur ? substr($texte, 0, $longueur) . "[...]" : $texte;
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
        if( file_exists($this->parametres->get("dossier_images") . $dossier . $nomImage) ) {
            $src =  $this->parametres->get("chemin_images") . $dossier .  $nomImage;
        } else {
            $src = "";
        }
        $alt = $alt ?: $nomImage;
        $balise = "<img src='$src' class='$classes' alt='$alt'>";
        // $balise = html_entity_decode($balise); // COURS obligatoire pour que twig accepte les balises HTML. ⚠ il faut utiliser 'raw'
        return $balise;
    }


    /**
    La fonction exit n'est pas utilisable dans twig normalement. 
     */
    public function exit()
    {
        exit;
    }



    /**
     * Les filtres que l'on veut ajouter doivent être renvoyés dans un array par la fonction getFilters
     * Chaque valeur de cet array est un objet de la classe TwigFilter
     * Les arguments du constructeur de TwigFilter :
     *      1er : le nom du filtre à utiliser dans les fichiers Twig
     *      2eme : la fonction qui est déclaré dans cette classe 
     *                  [ $this, nom_de_la_fonction_dans_la_classe ]

     * Je référence le nouveau filtre grâce à la méthode getFilters()
     * Si je veux ajouter une fonction, j'utilise la méthode getFunctions() et
     * pour ajouter un test, getTests()
     */
    public function getFilters()
    {
        return [ 
            new TwigFilter("autorisations", [$this, "autorisations"]),
            new TwigFilter("img", [$this, "baliseImg"]),
            new TwigFilter("resume", [$this, "resume"])
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('balise_image', [$this, 'baliseImg']),
            new TwigFunction('exit', [$this, 'exit']),
        ];
    }

    /**
     Ajouter des variables globales
     */
    public function getGlobals()
    {
        return [ "globale" => "c'est une variable globale"];
    }

    public function getOperators()
    {
        return [
            [
                '!' => ['precedence' => 50, 'class' => \Twig\Node\Expression\Unary\NotUnary::class],
            ],
            [
                '||' => ['precedence' => 10, 'class' => \Twig\Node\Expression\Binary\OrBinary::class, 'associativity' => \Twig\ExpressionParser::OPERATOR_LEFT],
                '&&' => ['precedence' => 15, 'class' => \Twig\Node\Expression\Binary\AndBinary::class, 'associativity' => \Twig\ExpressionParser::OPERATOR_LEFT],
            ],
        ];
    }    
}