<?php

namespace Eliberty\Bundle\FormElementTypeBundle\Validator\Constraints;

use JsonSchema\Validator as jsonValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class JsonSchemaValidator extends ConstraintValidator
{
    /**
     * @var object json
     */
    protected $schema;

    /**
     * @var object json
     */
    protected $data;

    /**
     * Validates a Ribkey using all other form datas
     * Beware, form data
     * @param  string     $value      [description]
     * @param  Constraint $constraint [description]
     * @return boolean                [description]
     */
    public function validate($value, Constraint $constraint)
    {
        $this->setSchemaAndData($value);
        // Validate/
        $validator = new jsonValidator();
        $validator->check($this->data, $this->schema);

        if (!$validator->isValid()) {
            $error = "";
            foreach ($validator->getErrors() as $validatorError) {
                $error .= sprintf(" le champs %s %s<br>", $validatorError['property'], $validatorError['message']);
            }
            $this->context->addViolation($error);
        }
    }

    /**
     * find the schema and the data for validate this field
     * @param $value
     */
    protected  function setSchemaAndData($value){

        $jsonObject= json_decode($value);

        if(property_exists($jsonObject,'schema')){
            $this->schema = $jsonObject->schema;
            $this->data = $jsonObject->data;
        } else {

            $fieldName = $this->context->getPropertyName();
            if(is_null($fieldName)) {
                $propertyName = [];
                preg_match_all('#\[(\w+)]#', $this->context->getPropertyPath(), $propertyName);
                $fieldName = (is_array($propertyName)) ? array_pop($propertyName)[0] : '';
            }

            $fieldOption = $this->context->getRoot()->get($fieldName)->getConfig()->getAttributes();
            $options = (is_array($fieldOption) && isset($fieldOption['data_collector/passed_options'])) ? $fieldOption['data_collector/passed_options'] : [];
            $attr = (is_array($options) && isset($options['attr'])) ? $options['attr'] : [];

            $this->schema = (is_array($attr) && isset($attr['schema'])) ?  json_decode($attr['schema']) :  json_decode('{}');
            $this->data = $jsonObject;
        }
    }
}
