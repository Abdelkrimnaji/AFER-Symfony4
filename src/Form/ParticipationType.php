<?php

namespace App\Form;

use App\Entity\Cas;
use App\Entity\Stage;
use App\Entity\Stagiaire;
use App\Entity\Participation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
           
             ->add('stages', EntityType::class, [
                 'class' => Stage::class,
                 'choice_label' => 'numeroStage',
                 'choice_label' => function (Stage $stage) {
                  return $stage->getNumeroStage() . ' du ' . $stage->getdated()->format('d-m-Y'). ' au ' . $stage->getdatef()->format('d-m-Y');;
              },
              ])
             ->add('stagiaires', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => 'nomStagiaire',
                'placeholder' => 'Choisir un ou des stagiaires',
                // 'multiple' => 'true',
                'attr' => array('class' => 'stagiaire-select'),
               
                
                
             ])
             ->add('cass',EntityType::class, [
                'class' => Cas::class,
                'choice_label' => 'numeroCas',
               'placeholder' => 'Cas',
               
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}
