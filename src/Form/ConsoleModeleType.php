<?php

namespace App\Form;

use App\Entity\ConsoleModele;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsoleModeleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix')
            ->add('nom')
            ->add('dateSortie')
            ->add('console')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConsoleModele::class,
        ]);
    }
}
