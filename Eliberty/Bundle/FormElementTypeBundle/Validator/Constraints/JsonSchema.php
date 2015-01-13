<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class JsonSchema extends Constraint
{
    public $message = 'json Invalide';
}
