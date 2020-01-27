<?php

namespace App\Form;

use App\Entity\Cas;
use App\Entity\Stage;
use App\Entity\Licence;
use App\Entity\Avantage;
use App\Entity\Civilite;
use App\Entity\Tribunal;
use App\Entity\Stagiaire;
use App\Entity\Infraction;
use App\Entity\Prefecture;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('civilite', EntityType::class, [
            'class' => Civilite::class,
            'choice_label' => 'nomCivilite',
            'placeholder' => 'Choisir une civilité'
            ])
            ->add('nomStagiaire')
            ->add('prenomStagiaire')
            ->add('nomNaissanceStagiaire')
            ->add('dateNaissanceStagiaire',BirthdayType::class, [
                'placeholder' => [
                'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année'
            ],
                'format' => 'd M y'
                
                ])
            ->add('lieuNaissanceStagiaire')
            ->add('adresseStagiaire')
            ->add('communeStagiaire')
            ->add('nationaliteStagiaire')
            ->add('numeroPortableStagiaire', null, [
                'required'   => false,
                'empty_data' => '-- -- -- -- --',
            ])
            ->add('numeroFixeStagiaire', null, [
                'required'   => false,
                'empty_data' => '-- -- -- -- --',
            ])
            ->add('emailStagiaire', null, [
                'required'   => false,
            ])
            
            ->add('numeroAdresseStagiaire')
           
            ->add('stage', EntityType::class, [
               'class' => Stage::class,
               'choice_label' => 'numeroStage',
               'choice_label' => function (Stage $stage) {
                return $stage->getNumeroStage() . ' du ' . $stage->getdated()->format('d-m-Y'). ' au ' . $stage->getdatef()->format('d-m-Y');;
            },
               
               'placeholder' => 'Choisir un ou des stages',
               'attr' => array('class' => 'stage-select'),
               'multiple' => 'true',
               'expanded' => 'true',   
               'query_builder' => function (EntityRepository $er) {
                     return $er->createQueryBuilder('s')
                       ->andWhere('s.dated >= :now')
                        ->orderBy('s.dated', 'ASC')
                        ->setParameter('now', new \DateTime());  
               },                
               ])
                    
                ->add('licence', EntityType::class, [
                  'class' => Licence::class,
                 'placeholder' => 'Numéro de permis',
                 'label'   => false,
                 'required'   => false,
                ])
               
                ->add('avantage',EntityType::class, [
                    'class' => Avantage::class,
                    'choice_label' => 'avantage',
                   'placeholder' => 'Avantages',
                   'expanded' => 'true' ,
                   'label'   => false,
                ])

                ->add('cas',EntityType::class, [
                    'class' => Cas::class,
                   'placeholder' => 'Cas',
                   'expanded' => 'true',
                   'multiple' => 'true',
                   'label'   => false, 
                ])

                ->add('infraction', EntityType::class, [
                    'class' => Infraction::class,
                   'placeholder' => 'Infraction',
                   'label'   => false,
                   'required'   => false,                   
                  ])
               ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }

    
}