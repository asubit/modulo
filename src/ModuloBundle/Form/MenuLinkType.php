<?php

namespace ModuloBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuLinkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('menu', 'entity', array(
                'class' => 'ModuloBundle:Menu',
                'choice_label' => 'title'
            ))
            ->add('type', 'choice', array(
                'choices'   => array('' => '', 'p' => 'Page', 'c' => 'Category', 'l' => 'Custom link'),
                'required'  => true,
            ))
            ->add('target')
            ->add('text')
            ->add('category', 'entity', array(
                'class' => 'ModuloBundle:Category',
                'choice_label' => 'title'
            ))
            ->add('page', 'entity', array(
                'class' => 'ModuloBundle:Page',
                'choice_label' => 'name'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModuloBundle\Entity\MenuLink'
        ));
    }
}
