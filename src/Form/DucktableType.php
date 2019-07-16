<?php

namespace App\Form;

use App\Entity\Ducktable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DucktableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Firstname')
            ->add('Lastname')
            ->add('Duckname')
            ->add('Email')
            ->add('Password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ducktable::class,
        ]);
    }
}
