<?php

namespace App\Form;

use App\Entity\Commune;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommuneType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder;
           
            // ->add('commune')
            // ->add('cp');
            // ->add('region')
            // ->add('departement')
            // ->add('latitude')
            // ->add('longitude')
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commune::class,
        ]);
    }
}
