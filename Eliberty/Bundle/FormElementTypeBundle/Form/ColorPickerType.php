<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ColorPickerType
 * responsability: overload the text fields turning it into color style
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class ColorPickerType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'colorpicker_widget'
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
        return 'eliberty_colorpicker';
    }
}