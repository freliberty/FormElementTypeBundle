<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Class SkiCardTransformer
 * @package Eliberty\RedpillBundle\Form\DataTransformer
 */
class SkiCardTransformer implements DataTransformerInterface
{

    private $fields;

    /**
     * Constructor.
     *
     * @param array $fields The date fields
     *
     * @throws UnexpectedTypeException if a timezone is not a string
     */
    public function __construct(array $fields = null)
    {
        if (null === $fields) {
            $fields = ['chip', 'base', 'luhn','crc','wtp','acceptance'];
        }

        $this->fields = $fields;
    }

    /**
     * Transforms a label to remove unwanted characters.
     *
     * @param null $value
     *
     * @return array
     */
    public function transform($value = null)
    {
        if (null === $value) {
            return null;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $result = [];
        $tmpFields = explode('-',$value);
        foreach ($this->fields as $fld) {
            if (count($tmpFields)) {
                $result[$fld] = array_shift($tmpFields);
            }
        }
        if (!empty($result['chip']) && (string) $result['chip'] ==='1') {
            $result['chip'] = '01';
        }

        return $result;
    }

    /**
     * reverse normalization
     *
     * @param null $value
     *
     * @return string
     */
    public function reverseTransform($value = null)
    {
        if (null === $value) {
            return '';
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        if ('' === implode('', $value)) {
            return null;
        }

        $emptyFields = array();

        foreach ($this->fields as $field) {
            if (!isset($value[$field])) {
                $emptyFields[] = $field;
            }
        }

        if (count($emptyFields) > 0) {
            throw new TransformationFailedException(
                sprintf('The fields "%s" should not be empty', implode('", "', $emptyFields)
            ));
        }

        if (isset($value['chip']) && !ctype_digit($value['chip']) && !is_int($value['chip'])) {
            throw new TransformationFailedException('This chip number is invalid');
        } elseif (!empty($value['chip']) && (string) $value['chip'] ==='1') {
            $value['chip'] = '01';
        }

        if (isset($value['base']) && !ctype_digit($value['base']) && !is_int($value['base'])) {
            throw new TransformationFailedException('This base number is invalid');
        }

        if (isset($value['luhn']) && !ctype_digit($value['luhn']) && !is_int($value['luhn'])) {
            throw new TransformationFailedException('This luhn number is invalid');
        }

        if (isset($value['wtp']) && !ctype_alnum($value['wtp']) && !is_string($value['wtp'])) {
            throw new TransformationFailedException('This wtp number is invalid');
        }

        if (isset($value['crc']) && !ctype_alnum($value['crc']) && !is_string($value['crc'])) {
            throw new TransformationFailedException('This crc number is invalid');
        }

        if (isset($value['acceptance']) && !ctype_alnum($value['acceptance']) && !is_string($value['acceptance'])) {
            throw new TransformationFailedException('This acceptance number is invalid');
        }

        return strtoupper(implode('-',$value));
    }
}
