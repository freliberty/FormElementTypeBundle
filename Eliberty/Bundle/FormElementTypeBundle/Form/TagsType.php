<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class TagsType
 * Responsability: overload the entity fields and turning it into tags field
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class TagsType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'tags_widget'
        ));
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eliberty_tags';
    }


}
