<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class InversedBooleanType
 * responsability: overload the text fields turning it into an "inversed" boolean style
 * ===> false is display as On and true is display as Off
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class InversedBooleanType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'inversed_boolean_widget'
        ));
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eliberty_inversed_boolean';
    }
}
