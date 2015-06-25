<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Eliberty\Bundle\FormElementTypeBundle\Form\DataTransformer\SkiCardTransformer;

/**
 * Class KeycardTeamaxessType
 * @package Eliberty\RedpillBundle\Form\FormElementType
 */
class KeycardTeamaxessType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $wtpOptions = $crcOptions = $acceptOptions = [
            'required'             => $options['required'],
            'label_render'         => false];

        $wtpOptions['label_render'] = false;
        $wtpOptions['attr'] = ['maxlength' => 8];
        $crcOptions['attr'] = ['maxlength' => 3];
        $acceptOptions['attr'] = ['maxlength' => 3];

        $builder
            ->add('wtp', "text", $wtpOptions)
            ->add('crc', "text", $crcOptions)
            ->add('acceptance', "text", $acceptOptions)
            ->addViewTransformer($this->getTransformer());



    }

    /**
     * @return SkiCardTransformer
     */
    public function getTransformer()
    {
        return new SkiCardTransformer(['wtp', 'crc', 'acceptance']);
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $compound = function (Options $options) {
            return true;
        };

        $emptyValue = $emptyValueDefault = function (Options $options) {
            return $options['required'] ? null : '';
        };

        $emptyValueNormalizer = function (Options $options, $emptyValue) use ($emptyValueDefault) {
            if (is_array($emptyValue)) {
                $default = $emptyValueDefault($options);

                return array_merge(
                    ['wtp' => $default, 'crc' => $default, 'acceptance' => $default],
                    $emptyValue
                );
            }

            return [
                'wtp'        => $emptyValue,
                'crc'        => $emptyValue,
                'acceptance' => $emptyValue
            ];
        };

        $resolver->setDefaults([
                'compound'          => $compound,
                'required'          => false,
                'empty_value'       => $emptyValue,
                'error_bubbling'    => true,
                'data_class'        => null
            ]
        );

        $resolver->setNormalizers([
            'empty_value' => $emptyValueNormalizer,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eliberty_keycard_teamaxess';
    }

}
