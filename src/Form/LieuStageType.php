<?php

namespace App\Form;

use App\Entity\LieuStage;
use App\Entity\Commune;
use App\Entity\Civilite;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class LieuStageType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_etablissement')
            ->add('agrement', null, [
                'required'   => false,
                'empty_data' => 'Aucun numéro d\'agrément fourni',
            ])
            ->add('adresse_stage')
            ->add('numero_adresse_stage', null, [
                'required'   => false
            ])
            ->add('latitude')
            ->add('longitude')
            ->add('dmsLatitude')
            ->add('dmsLongitude')
            ->add('telephone_stage', null, [
                'required'   => false,
                'empty_data' => '-- -- -- -- --',
            ])
            ->add('divers')
            ->add('nom_commune')
            ;      
    }
}