<?php

namespace Projet3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type'            => PasswordType::class,
                 'invalid_message' => 'Le mot de passe doit être identique.',
                 'options'         => array('required' => true),
                 'first_options'   => array('label' => 'Mot de passe'),
                 'second_options'  => array('label' => 'Resaisir le mot de passe'),
             ))
            ->add('role', ChoiceType::class, array(
                'choices' => array('Admin' => 'ROLE_ADMIN', 'Contributeur' => 'ROLE_USER')
            ));
    }

    public function getName()
    {
        return 'user';
    }
}
