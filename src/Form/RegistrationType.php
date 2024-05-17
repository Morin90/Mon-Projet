<?php

namespace App\Form;

use Assert\Length;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, 
            [
                'attr' => [
                'class' => 'form-control',
                'minlength' => '3',
                'maxlength' => '50'
                ],
                'label' => 'Nom et Prénom',
                'label_attr' => [
                'class' => 'form-label mt-4'

                ],
                'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 3, 'max' => 50])
                ]
            ])
            ->add('pseudo', TextType::class,
            [
            'required' => false,
            'attr' => [
                'class' => 'form-control ',
                'minlength' => '3',
                'maxlength' => '50',
                
                ],
                'label' => 'Pseudo (pas obligatoire)',
                'label_attr' => [
                'class' => 'form-label mt-2',


                ],
                'constraints' => [
                new Assert\Length(['min' => 3, 'max' => 50])
                ]
            ])
            ->add('email', EmailType::class,
            [
                'attr' => [
                'class' => 'form-control ',
                'minlength' => '3',
                'maxlength' => '180'
                ],
                'label' => 'Adresse mail',
                'label_attr' => [
                'class' => 'form-label mt-2'
                ],
                'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Length(['min' => 3, 'max' => 180])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control mt-2'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'class' => 'form-control mt-2 mb-3'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
            ])
            ->add ('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-2'
                ],
                'label' => 'S\'inscrire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
