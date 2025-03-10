<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
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
            'label' => 'Pseudo (facultatif)',
            'label_attr' => [
            'class' => 'form-label mt-2',


            ],
            'constraints' => [
            new Assert\Length(['min' => 3, 'max' => 50])
            ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
            ],
            'label' => 'Mot de passe',
            'label_attr' => [
                'class' => 'form-label mt-2'
                ],
            ])
            ->add ('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-2',
                    'style' => 'background-color: var(--b-violet)'
                ],
                'label' => 'Mettre a jour'
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
