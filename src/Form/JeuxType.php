<?php

namespace App\Form;

use App\Entity\Jeux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('ageMini')
            ->add('description')
            ->add('prix')
            ->add('dateSortie')
            ->add('marque')
            ->add('console')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeux::class,
        ]);
    }
}
