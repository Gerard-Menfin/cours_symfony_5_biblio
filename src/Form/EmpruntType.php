<?php

namespace App\Form;

use App\Entity\Abonne;
use App\Entity\Emprunt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Livre;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateEmprunt', DateType::class, [
                "widget" => "single_text",
                "label" => "Emprunté le",
                // "data" => new DateTime()  // si je choisis une valeur par défaut à un champ, cette valeur écrase la valeur existante de l'objet passé en 
                                             // paramètre pour créer le formulaire (par exemple, quand j'affiche le formulaire pour modifier un enregistrement
                                             //  existant)
                // "empty_data" => new DateTime("now")  // ne change rien pour un DateType
            ])
            ->add('dateRetour', DateType::class, [
                "widget" => "single_text",
                "label" => "Rendu le ",
                "required" => false
            ])
            ->add('abonne', EntityType::class, [
                "class" => Abonne::class,
                "choice_label" => "pseudo",
                "placeholder" => "choisir un abonné..."
            ])
            ->add('livre', EntityType::class, [
                "class" => Livre::class,
                "choice_label" => function($livre){
                    return $livre->getTitre() . " - " . $livre->getAuteur()->getIdentite();
                },
                "placeholder" => "choisir un livre..."

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
