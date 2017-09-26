<?php

namespace ModuloBundle\Form;

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
                'choice_label' => 'title',
                'label' => 'Menu',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('type', 'choice', array(
                'choices'   => array('' => 'Select menu link type', 'p' => 'Page', 'c' => 'Category', 'l' => 'Custom link'),
                'required'  => true,
            ))
            ->add('target')
            ->add('text')
            ->add('category', 'entity', array(
                'class' => 'ModuloBundle:Category',
                'choice_label' => 'title',
                'empty_data' => 'Select category...',
                'label' => 'Category',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('page', 'entity', array(
                'class' => 'ModuloBundle:Page',
                'choice_label' => 'name',
                'empty_data' => 'Select page...',
                'label' => 'Page',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
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
