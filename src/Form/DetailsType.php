<?php

namespace App\Form;

use App\Entity\Details;
use App\Entity\Velo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taille')
            ->add('roues')
            ->add('vitesse')
            ->add('velo', EntityType::class, [
                'class' => Velo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Details::class,
    //     ]);
    // }
}
