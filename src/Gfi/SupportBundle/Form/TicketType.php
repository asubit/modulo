<?php

namespace Gfi\SupportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TicketType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sujet')
            ->add('description')
            ->add('criticite', new ChoiceType(), array(
                'choices'  => array(
                    'Mineur' => 'mineur',
                    'Majeur' => 'majeur',
                    'Bloquant' => 'bloquant',
                ),
                'choices_as_values' => true,
            ))
            ->add('fichier', new FileType(), array('required' => false))
            ->add('statut', new HiddenType(), array(
                'data' => 'Nouveau',
            ))
            ->add('date', null, array(
                'attr'=>array('style'=>'display:none;')
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gfi\SupportBundle\Entity\Ticket'
        ));
    }
}
