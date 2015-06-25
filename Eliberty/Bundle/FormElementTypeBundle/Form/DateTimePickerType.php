<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DateTimePickerType
 * @package Eliberty\Bundle\FormElementTypeBundle\Form
 */
class DateTimePickerType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'single_text'
        ));
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
        return 'eliberty_datetime_picker';
    }
}