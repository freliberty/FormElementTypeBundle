<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class DatePickerType
 * responsability: overload the datetime fields and turning it into the custom datetime field
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class DatePickerType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['widget' => 'datepicker_widget']);
        
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'datetime';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eliberty_datepicker';
    }
}