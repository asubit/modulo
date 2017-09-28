<?php

namespace ModuloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('position', 'choice', array(
                'choices'   => array(
                    '' => 'Select menu position',
                    'top' => 'Navbar top',
                    'left' => 'Column left',
                    'right' => 'Column right'
                ),
                'required'  => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModuloBundle\Entity\Menu'
        ));
    }
}
