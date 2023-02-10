<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Livre1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                "label"         => "Titre du livre",
                "required"      => false,
                "constraints"   => [
                    new NotBlank([
                        "message" => "Le titre ne peut pas être vide !"
                    ]),
                    new Length([
                        "min" => 2,
                        "minMessage" => "Le titre doit comporter 2 caractères minimun",
                        "max" => 50,
                        "maxMessage" => "Le titre ne doit pas comporter plus de 50 caractères"
                    ])
                ]
            ])
            ->add('auteur', EntityType::class, [
                'class'         => Auteur::class,
                "choice_label"  => "identite",
                "placeholder"   => "Choisir parmi les auteurs enregistrés..."
            ])
            ->add('couverture', FileType::class,  [ 
                "mapped"        => false, 
                "required"      => false,
                "constraints"   => [ 
                    new File([ 
                                "mimeTypes" => [  "image/gif", "image/jpeg", "image/png" ],
                                "mimeTypesMessage" => "Les formats autorisés sont gif, jpeg, png",
                                "maxSize" => "2048k",
                                "maxSizeMessage" => "Le fichier ne peut pas faire plus de 2Mo"
                    ])
                ],
                "help" => ""
            ])
            ->add('genres', EntityType::class, [
                'class'         => Genre::class,
                "choice_label"  => "libelle",
                'multiple'      => true,
                'expanded'      => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
