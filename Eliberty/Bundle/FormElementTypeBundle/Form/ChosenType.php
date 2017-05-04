<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChosenType
 * responsability: overload the choice fields turning it into chosen style
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class ChosenType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'chosen_widget'
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
        return 'eliberty_chosen';
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}