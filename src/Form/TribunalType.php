<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Tribunal;
use App\Entity\TribunalService;
use App\Entity\TribunalAutorite;



class TribunalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_tribunal')
            ->add('adresse_tribunal')
            ->add('numero_adresse_tribunal')
            ->add('commune_tribunal')
            ->add('tribunal_service', EntityType::class, [
                'class' => TribunalService::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un service '
            ])
            ->add('tribunal_autorite', EntityType::class, [
                'class' => TribunalAutorite::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une autorité'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tribunal::class,
        ]);
    }
}
