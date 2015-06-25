<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileUploadType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'widget' => 'file_upload_widget'
        ));
    }
    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'eliberty_file_upload';
    }
}
