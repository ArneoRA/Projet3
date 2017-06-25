<?php

namespace Projet3\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contenu', TextareaType::class)
                ->add('parentid', TextType::class, //Permettant la gestion des sous commentaires
                array('attr'=> array(
                    'class'=> 'hidden')
                ))
                ->add('niveau', TextType::class, // Permettant la gestion des niveaux
                array('attr'=> array(
                    'class'=> 'hidden')
                ));
    }

    public function getName()
    {
        return 'comment';
    }
}
