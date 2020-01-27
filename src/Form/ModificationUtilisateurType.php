<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ModificationUtilisateurType extends AbstractType
{
    const ADMIN = 'ROLE_ADMIN';
    const PREFECTURE = 'ROLE_PREFECTURE';
    const TRIBUNAL = 'ROLE_TRIBUNAL';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = $options['data']->getRoles();
        if(count($roles) === 0) {
            $goodRoles = self::ADMIN;
        } else {
            $goodRoles = $roles[0];
        }
        
        $builder
            ->add('nomUser')
            ->add('prenomUser')
            ->add('email')
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'ADMIN' => self::ADMIN,
                    'PREFECTURE' => self::PREFECTURE,
                    'TRIBUNAL' => self::TRIBUNAL
                ],
                'multiple' => false,
                'data' => $goodRoles
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
