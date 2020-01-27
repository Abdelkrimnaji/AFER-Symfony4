<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Commune;
use App\Entity\Civilite;
use App\Entity\Animateur;
use App\Entity\AnimateurStatut;
use App\Entity\AnimateurFonction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AnimateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite', EntityType::class, [
            'class' => Civilite::class,
            'choice_label' => 'nomCivilite',
            'placeholder' => 'Choisir une civilité'
            
           ])
            ->add('nom_animateur')
            ->add('prenom_animateur')
            ->add('raison_sociale_animateur', null, [
                'required'   => false,
                'empty_data' => 'Aucune raison sociale fournie',
            ])
            ->add('gta_animateur', ChoiceType::class, [
                'choices' => [
                    'Gestion technique et administrative' => [
                        'Non' => false,
                        'Oui' => true,
                        ],
                ],
            ])
            ->add('commune_animateur')
            ->add('region_animateur')
            ->add('rue_animateur')
            ->add('numero_rue_animateur')
            ->add('numero_portable_animateur', null, [
                'required'   => false,
                'empty_data' => '-- -- -- -- --',
            ])
            ->add('numero_fixe_animateur', null, [
                'required'   => false,
                'empty_data' => '-- -- -- -- --',
            ])
            ->add('email_animateur')
            ->add('urssaf_animateur', null, [
                'required'   => false,
                'empty_data' => 'Aucun numéro Urssaf fourni',
            ])
            ->add('siret_animateur', null, [
                'required'   => false,
                'empty_data' => 'Aucun numéro Siret fourni',
            ])
            ->add('observations_animateur', TextareaType::class, [
                'required'   => false,
                'empty_data' => 'Aucune observation'
        
            ])
            ->add('animateurStatut', EntityType::class, [
                'class' => AnimateurStatut::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un statut'
            ])
            ->add('animateurFonction', EntityType::class, [
                'class' => AnimateurFonction::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une fonction'
            ])
            
        ;
    }

    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animateur::class,
        ]);
    }
}
