<?php

namespace App\Form;

use App\Entity\Licence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class LicenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('licenceNumber')
            ->add('licenceDate',BirthdayType::class, [
                'placeholder' => [
                'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
            ],
                'format' => 'd M y',
                'years' => range(1940, date('Y'))
                
                ])
            ->add('prefecture')  
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Licence::class,
        ]);
    }
}
