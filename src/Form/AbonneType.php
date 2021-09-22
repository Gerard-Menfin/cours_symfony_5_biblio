<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("confirmation", CheckboxType::class, [
                "mapped" => false
            ])
            ->add('pseudo', TextType::class, [
                "attr" => [
                    "class" => "text-primary"
                ]
            ])
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Lecteur" => "ROLE_LECTEUR",
                    "Bibliothécaire" => "ROLE_BIBLIOTHECAIRE",
                    "Directeur" => "ROLE_ADMIN",
                    "Développeur" => "ROLE_DEV",
                    "Abonné" => "ROLE_USER"
                ],
                "multiple" => true,
                "expanded" => true,
                "label" => "Niveau d'accès"
            ])
            ->add('password', PasswordType::class, [
                "mapped" => false
            ])
            ->add('nom')
            ->add('prenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
