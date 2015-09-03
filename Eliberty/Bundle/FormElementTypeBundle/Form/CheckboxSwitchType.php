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
        $isIndeterminate = array_key_exists('indeterminate', $options) && $options['indeterminate'] ? 'true' :'false';
        $isAnimate = array_key_exists('animate', $options) && $options['animate'] ? 'true' :'false';
        $isRadioAllOff = array_key_exists('radioalloff', $options) && $options['radioalloff'] ? 'true' :'false';
        $size      = array_key_exists('size', $options) && in_array(strtolower($options['size']), ['mini', 'small', 'normal', 'large'])
            ? strtolower($options['size'])
            : null;
        $onColor   = array_key_exists('oncolor', $options) && in_array(strtolower($options['oncolor']), ['primary', 'info', 'success', 'warning', 'danger', 'default'])
            ? strtolower($options['oncolor'])
            : 'default';
        $offColor  = array_key_exists('offcolor', $options) && in_array(strtolower($options['offcolor']), ['primary', 'info', 'success', 'warning', 'danger', 'default'])
            ? strtolower($options['offcolor'])
            : 'default';
        $onText    = array_key_exists('ontext', $options) && strlen($options['ontext']) > 0 ? strtolower($options['ontext']) : 'ON';
        $offText   = array_key_exists('offtext', $options) && strlen($options['offtext']) > 0 ? strtolower($options['offtext']) : 'OFF';

        $builder->setAttribute('dataIndeterminate', $isIndeterminate);
        $builder->setAttribute('dataRadioAllOff', $isRadioAllOff);
        $builder->setAttribute('dataAnimate', $isAnimate);
        $builder->setAttribute('dataInverse', $isInverse);
        $builder->setAttribute('dataSize', $size);
        $builder->setAttribute('dataOnColor', $onColor);
        $builder->setAttribute('dataOffColor', $offColor);
        $builder->setAttribute('dataOnText', $onText);
        $builder->setAttribute('dataOffText', $offText);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['dataIndeterminate'] = $form->getConfig()->getAttribute('dataIndeterminate');
        $view->vars['dataRadioAllOff']   = $form->getConfig()->getAttribute('dataRadioAllOff');
        $view->vars['dataAnimate']       = $form->getConfig()->getAttribute('dataAnimate');
        $view->vars['dataInverse']       = $form->getConfig()->getAttribute('dataInverse');
        $view->vars['dataSize']          = $form->getConfig()->getAttribute('dataSize');
        $view->vars['dataOnColor']       = $form->getConfig()->getAttribute('dataOnColor');
        $view->vars['dataOffColor']      = $form->getConfig()->getAttribute('dataOffColor');
        $view->vars['dataOnText']        = $form->getConfig()->getAttribute('dataOnText');
        $view->vars['dataOffText']       = $form->getConfig()->getAttribute('dataOffText');
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
