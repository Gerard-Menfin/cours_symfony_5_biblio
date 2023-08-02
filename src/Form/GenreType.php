<?php

namespace App\Form;

use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * 💬 On ne peut pas récupérer un formulaire généré par une autre classe Form dans le 
         * 💬 contrôleur (avec 'createForm'). 
         * NB: s'il n'y a pas d'entité liée au formulaire, j'affiche un TextType au lieu d'un
         * NB: d'un TextareaType.
         */
        $genre = $options["data"] ?? null;
        $builder
            ->add('libelle', null,   [ "label"  => "Libellé" ])
            ->add('mots_cles', $genre ? TextareaType::class : TextType::class, [ "label"  => "Mots clés", "required" => false ])
            // ->add('livres')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Genre::class,
        ]);
    }
}
