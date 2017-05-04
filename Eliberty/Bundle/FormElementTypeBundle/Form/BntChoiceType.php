<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BntChoiceType
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class BntChoiceType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'bnt_choice_widget'
        ]);
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'eliberty_bnt_choice';
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}