<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $auteur = $options["data"] ?? null;
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('biographie', $auteur ? TextareaType::class : TextType::class, [
                "required"      => false
            ])
            ->add('naissance', DateType::class, [
                "widget"        =>  "single_text",  "required"  =>  false
            ])
            ->add('deces', DateType::class, [
                "widget"        =>  "single_text",  "required"  =>  false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
