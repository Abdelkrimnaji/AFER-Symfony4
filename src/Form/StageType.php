<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Tribunal;
use App\Entity\Animateur;
use App\Entity\LieuStage;
use App\Entity\Stagiaire;
use App\Entity\Prefecture;
use App\Entity\Participation;
use App\Form\ParticipationType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero_stage') 
            ->add('dated', DateType::class, [
                'widget' => 'single_text',
                'format'=>'yyyy-MM-dd',
                'html5' => true,
            ])
            
            ->add('datef', DateType::class, [
                'widget' => 'single_text',
                'format'=>'yyyy-MM-dd',
                'html5' => true,
            ])
            ->add('stage_programme_officiel', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                    
                ],
                'expanded' => 'true',
            ])

            ->add('lieuStage', EntityType::class, [
                'class' => LieuStage::class,
                'choice_label' => 'nomEtablissement',
                'placeholder' => 'Choisir un lieu de stage'
        
            
            ])    
            // ->add('prefecture', EntityType::class, [
            //     'class' => Prefecture::class,
            //     'choice_label' => 'nomPrefecture',
            //     'placeholder' => 'Choisir une préfecture'
            // ])    
            // ->add('tribunal', EntityType::class, [
            //     'class' => Tribunal::class,
            //     'choice_label' => 'nomTribunal',
            //     'placeholder' => 'Choisir un tribunal'
            // ])    
            ->add('animateurs', EntityType::class, [
                'class' => Animateur::class,
                'choice_label' => function (Animateur $animateur) {
                    return $animateur->getAnimateurFonction() . ' ' . $animateur->getPrenomAnimateur() . ' ' . $animateur->getNomAnimateur();
                },
                'placeholder' => 'Choisir un ou deux animateurs',
                'attr' => array('class' => 'animateur-select'),
                'multiple' => 'true',
                'expanded' => 'true',
                'group_by' =>  function (Animateur $animateur) {
                    return $animateur->getAnimateurFonction();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('anim')
                        ->orderBy('anim.nomAnimateur', 'ASC');
                },
            
            ])
             ->add('stagiaire', EntityType::class, [
                 'class' => Stagiaire::class,
                 'choice_label' => function (Stagiaire $stagiaire) {
                     return $stagiaire->getCivilite() . ' ' . $stagiaire->getPrenomStagiaire() . ' ' . $stagiaire->getNomStagiaire();
                 },
                 'placeholder' => 'Choisir un ou des stagiaires',
                 'multiple' => 'true',
                 'attr' => array('class' => 'stagiaire-select'),
                 'query_builder' => function (EntityRepository $er) {
                     return $er->createQueryBuilder('stag')
                         ->orderBy('stag.nomStagiaire', 'ASC');
                       
                 },
                 ])
                                   
            ;

    }
            
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
