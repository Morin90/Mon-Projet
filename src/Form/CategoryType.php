<?php

namespace App\Form;

use Assert\Length;
use App\Entity\Velo;
use Assert\NotBlank;
use App\Entity\Categorie;
use Doctrine\ORM\QueryBuilder;
use App\Repository\VeloRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-4',
                'minlength' => '3',
                'maxlength' => '50'],
                    'label' => 'Nom de votre catégorie',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\Length(['min' => 3, 'max' => 50]),
                        new Assert\NotBlank()
                    ]
                ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mt-4',
                'minlength' => '3',
                'maxlength' => '255'],
                    'label' => 'Description de votre catégorie',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\Length(['min' => 3, 'max' => 255]),   
                        new Assert\NotBlank()
                    ]
            ])
            
            ->add('velos' , EntityType::class, [
                
    'class' => Velo::class,
    'query_builder' => function (VeloRepository $vr): QueryBuilder {
        return $vr->createQueryBuilder('v')
            ->orderBy('v.name', 'ASC');
            
    },
    'multiple' => true,
    'expanded' => true,
    'choice_label' => 'name',
    'label' => 'Vélos',
    'attr' => [ 
        'class' => 'example-wrapper'
    ]        
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer votre catégorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
