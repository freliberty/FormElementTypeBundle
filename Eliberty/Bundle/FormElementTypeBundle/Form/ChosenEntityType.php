<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChosenEntityType
 * responsability: overload the entity fields turning it into chosen style
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class ChosenEntityType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'chosen_entity_widget'
        ]);
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'eliberty_chosen_entity';
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}