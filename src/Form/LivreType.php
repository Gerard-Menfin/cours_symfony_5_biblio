<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                "label" => "Titre du livre",
                "required" => false,
                "constraints" => [
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
            ->add('auteur', TextType::class, [
                "help" => "Tapez le nom de l'auteur du livre"
            ])
            ->add("enregistrer", SubmitType::class, [
                "attr" => [ "class" => "btn btn-primary" ]
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
