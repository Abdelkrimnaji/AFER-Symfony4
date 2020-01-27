<?php

namespace App\Form;

use App\Entity\Prefecture;
use App\Entity\PrefectureService;
use App\Entity\PrefectureAutorite;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PrefectureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomPrefecture')
            ->add('numeroAdressePrefecture')
            ->add('adressePrefecture')
            ->add('communePrefecture')
            ->add('prefectureService', EntityType::class, [
                'class' => PrefectureService::class, 
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un service'
            ])
            ->add('prefectureAutorite', EntityType::class, [
                'class' => PrefectureAutorite::class, 
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une autorité'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prefecture::class,
        ]);
    }
}
