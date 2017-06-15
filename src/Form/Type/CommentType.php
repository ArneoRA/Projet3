<?php

namespace Projet3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pseudo', TextType::class)
                ->add('contenu', TextareaType::class)
                ->add('parentid', TextType::class,
                array('attr'=> array(
                    'class'=> 'hidden')
                ))
                ->add('niveau', TextType::class,
                array('attr'=> array(
                    'class'=> 'hidden')
                ));
    }

    public function getName()
    {
        return 'comment';
    }
}
