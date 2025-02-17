<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les C.G.U.',
                    ]),
                ],
                "label" => "J'accepte les C.G.U."
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le mot de passe devrait comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    // new Regex([
                    //     "pattern" => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/",
                    //     "message" => "Le mot de passe doit être composé d'au moins une minuscule, une majuscule, un chiffre , un caractère spécial -+!*$@%_, et 
                    //                     avoir entre 8 et 15 caractères"
                    // ])
                ],
            ])
            ->add('prenom', null, [
                "constraints" => [
                    new Length([
                        "max"           =>  20,
                        "maxMessage"    =>  "Le prénom ne doit pas contenir plus de 20 caractères",
                    ])
                ],
                "attr"  => [ "placeholder" => "Prénom", "class" => "bg-info" ]
            ])
            ->add('nom', null, [
                "constraints"   =>  [
                    new Length([
                        "max"           =>  30,
                        "maxMessage"    =>  "Le nom ne doit pas contenir plus de 30 caractères",
                    ]),
                    new NotBlank([ "message" => "Le nom ne peut pas être vide !" ])
                ], 
            ])
            ->add('naissance', DateType::class, [
                "widget"    =>  "single_text",
                "required"      =>  false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
