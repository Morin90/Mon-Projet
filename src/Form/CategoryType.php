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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-4',
                    'minlength' => '3',
                    'maxlength' => '50'
                ],
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
                    'maxlength' => '2550'
                ],
                'label' => 'Description de votre catégorie',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 3, 'max' => 2550]),
                    new Assert\NotBlank()
                ]
            ])

            ->add('velos', EntityType::class, [

                'class' => Velo::class,
                'query_builder' => function (VeloRepository $vr) use ($options): QueryBuilder {
                    return $vr->createQueryBuilder('v')
                        ->where('v.categorie IS NULL')
                        ->orWhere('v.categorie = :id')
                        ->setParameter('id', $options['categorie_id'])
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
                    'class' => 'btn text-white mt-4 mb-4 mx-auto d-block',
                    'style' => 'background-color: var(--b-violet)'
                ],
                'label' => 'Créer votre catégorie'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'label' => 'Image',
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
            'categorie_id' => null,
        ]);
    }
}
