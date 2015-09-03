<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CheckboxToggleType
 * responsability: overload the checkbox fields turning it into on-off button style
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class CheckboxSwitchType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isInverse = array_key_exists('inverse', $options) && $options['inverse'] ? 'true' :'false';
        $builder->setAttribute('data-inverse', $isInverse);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['data-inverse'] = $form->getConfig()->getAttribute('data-inverse');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'checkboxswitch_widget'
        ]);
    }

    /**
     * @return null|string|FormTypeInterface
     */
    public function getParent()
    {
        return 'checkbox';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eliberty_checkboxswitch';
    }
}
