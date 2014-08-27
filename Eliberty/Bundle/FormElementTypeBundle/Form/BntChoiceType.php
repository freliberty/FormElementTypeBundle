<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BntChoiceType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'bnt_choice_widget'
        ));
    }
    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'eliberty_bnt_choice';
    }
}