<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Repository\GenreRepository;
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

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
                                "mimeTypesMessage" => "Rappel : les formats autorisés sont gif, jpeg, png",
                                "maxSize" => "2048k",
                                "maxSizeMessage" => "Le fichier ne doit pas peser plus de 2Mo"
                    ])
                ],
                "help" => "Formats autorisés : image (jpeg, gif, png)"
            ])
            ->add('genres', EntityType::class, [
                'class'         => Genre::class,
                "choice_label"  => "libelle",
                "query_builder" => function(GenreRepository $gr) {
                    return $gr->createQueryBuilder("g")->orderBy("g.libelle");
                },
                'multiple'      => true,
                'expanded'      => true,
                'attr'          => [ "class" => "d-flex flex-wrap justify-content-around px-3"],
            ])
            ->add('resume', null, [
                "label"         =>  "Résumé"
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
