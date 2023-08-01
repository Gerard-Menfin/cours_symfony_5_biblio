<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LivreInlineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                "label"         => "Titre du livre",
                "required"      => false,
                "constraints"   => [
                    new NotBlank([ "message" => "Le titre ne peut pas être vide !" ]),
                    new Length([
                        "min" => 2,
                        "minMessage" => "Le titre doit comporter 2 caractères minimun",
                        "max" => 50,
                        "maxMessage" => "Le titre ne doit pas comporter plus de 50 caractères"
                    ])
                ]
            ])
            ->add('couverture', FileType::class,  [ 
                "mapped"        => false, 
                "required"      => false,
                "constraints"   => [ 
                    new File([ 
                                "mimeTypes" => [  "image/gif", "image/jpeg", "image/png" ],
                                "mimeTypesMessage" => "Rappel : les formats autorisés sont gif, jpeg, png",
                                "maxSize" => "2048k",
                                "maxSizeMessage" => "Le fichier ne doit pas peser plus de 2Mo"
                    ])
                ],
                "row_attr"          =>  [ "style" => "width: 80px;" ],
                "help" => "Formats autorisés : image (jpeg, gif, png)"
            ])
            ->add('auteur', EntityType::class, [
                'class'         => Auteur::class,
                "choice_label"  => "identite",
                "placeholder"   => "Choisir parmi les auteurs enregistrés..."
            ])
            ->add('enregistrer', SubmitType::class, [
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
