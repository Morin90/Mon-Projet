<?php

namespace App\Form;

use App\Entity\Velo;
use App\Entity\Brand;
use App\Entity\Frame;
use App\Entity\Wheel;
use App\Entity\Transmission;
use App\Repository\BrandRepository;
use App\Repository\FrameRepository;
use App\Repository\WheelRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\TransmissionRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Marque du vélo',
                'label_attr' => [
                    'class' => 'form-label mt-2'
                ],
                'query_builder' => function (BrandRepository $brand) {
                    return $brand->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC');
                },
                'constraints' => [
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
                'class' => Frame::class ,
                'choice_label' => 'size',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'example-wrapper'
                ],
                'query_builder' => function (FrameRepository $frame) {
                    return $frame->createQueryBuilder('f')
                        ->orderBy('f.size', 'ASC');
                },
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('wheels', EntityType::class, [
                'class' => Wheel::class,
                'choice_label' => 'size',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'example-wrapper'
                ],
                'query_builder' => function (WheelRepository $wheel) {
                    return $wheel->createQueryBuilder('w')
                        ->orderBy('w.size', 'ASC');
                },
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('transmissions', EntityType::class, [
                'class' => Transmission::class,
                'choice_label' => 'number',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'example-wrapper'
                ],
                'query_builder' => function (TransmissionRepository $transmission) {
                    return $transmission->createQueryBuilder('t')
                        ->orderBy('t.number', 'ASC');
                },
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('prix', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control mt-2 mt-2 form-control-lg',
                    'style' => 'width: 50%'
                ],
                'label' => 'Prix du vélo',
                'label_attr' => [
                    'class' => 'form-label1 '
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
                'label_attr' => [
                    'class' => 'imgform_size'
                ]
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
