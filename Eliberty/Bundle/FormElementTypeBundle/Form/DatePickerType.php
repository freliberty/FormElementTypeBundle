<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DatePickerType
 * responsability: overload the datetime fields and turning it into the custom datetime field
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class DatePickerType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['widget' => 'datepicker_widget']);
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return DateTimeType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'eliberty_datepicker';
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}