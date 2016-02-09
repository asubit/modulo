<?php

namespace Gfi\SupportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RappelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ticket', new TicketType())
            ->add('telephone')
            ->add('date', 'date', array(
                'widget'=>'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
                )
            ))
            ->add('heure', 'time', array(
                'widget'=>'single_text',
                'attr' => array(
                    'class' => 'form-control input-inline timepicker',
                    'data-provide' => 'timepicker',
                    'data-time-format' => 'H:i'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gfi\SupportBundle\Entity\Rappel'
        ));
    }
}
