<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;

/**
 * Class TranslateTextAreaType
 * @package Eliberty\Bundle\FormElementTypeBundle\Form
 */
class TranslateTextAreaType extends AbstractType
{

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eliberty_translatetextarea';
    }

}
