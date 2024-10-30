<?php

namespace App\Form;

use App\Entity\Frame;
use App\Entity\Transmission;
use App\Entity\Velo;
use App\Entity\Wheel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VeloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '50'
                ],
                'label' => 'Nom du vélo',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 3, 'max' => 50]),
                    new Assert\NotBlank()
                ],
            ])
            ->add('marque', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '25'
                ],
                'label' => 'Marque du vélo',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 3, 'max' => 25]),
                    new Assert\NotBlank()
                ]
                ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'minlength' => '3',
                    'maxlength' => '2550'
                ],
                'label' => 'Description de votre vélo',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 3, 'max' => 2550]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('frames', EntityType::class, [
                'class' => Frame::class,
                'choice_label' => 'size',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('wheels', EntityType::class, [
                'class' => Wheel::class,
                'choice_label' => 'size',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('transmissions', EntityType::class, [
                'class' => Transmission::class,
                'choice_label' => 'number',
                'multiple' => true,
                'expanded' => true
            ])
            // ->add('taille',TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control'   
            //     ],
            //     'label' => 'Taille du vélo',
            //     'constraints' => [
            //         new Assert\NotBlank(),
            //         new Assert\Positive()
            //     ],
            //     'mapped' => false
            //     ])
            //     ->add('vitesses', IntegerType::class, [
            //         'attr' => [
            //             'class' => 'form-control'   
            //         ],
            //         'label' => 'Nombre de vitesses',
            //         'constraints' => [
            //             new Assert\NotBlank(),
            //             new Assert\Positive()
            //         ],
            //         'mapped' => false
            //         ])
            // ->add ('roues', IntegerType::class, [
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'label' => 'Taille de roues',
            //     'constraints' => [ 
            //         new Assert\NotBlank(),  
            //         new Assert\Positive()
            //     ],
            //     'mapped' => false
            //     ])
            ->add('prix', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prix    ',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(50000)
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => 'Image',
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-custom  mt-4 mx-auto d-block'
                ],
                'label' => 'Mettre à jour'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Velo::class,
        ]);
    }
}
