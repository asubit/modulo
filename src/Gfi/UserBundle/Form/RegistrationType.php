<?php

namespace Gfi\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', 'choice', array(
                'choices'  => array(
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                ),
                'expanded' => true,
                'multiple' => false,
                'choices_as_values' => true,
            ))
            ->add('lastname')
            ->add('firstname')
            ->add('tntAccount')
            ->add('captcha', 'Gregwar\CaptchaBundle\Type\CaptchaType', array(
                'width' => 192,
                'height' => 45,
                'length' => 6,
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gfi\UserBundle\Entity\User'
        ));
    }
}
