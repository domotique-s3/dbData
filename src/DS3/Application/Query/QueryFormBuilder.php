<?php

namespace DS3\Application\Query;

use DS3\Framework\Form\FormBuilderInterface;
use DS3\Framework\Form\Form;
use DS3\Framework\Form\Type\AssociativeArrayType;
use DS3\Framework\Form\Type\DoubleType;
use DS3\Framework\Form\Type\IntegerType;
use DS3\Framework\Form\Type\SequentialArrayType;
use DS3\Framework\Form\Type\StringType;
use DS3\Framework\Form\Validation\AssociativeArrayValidator;
use DS3\Framework\Form\Validation\GreaterThanValidator;
use DS3\Framework\Form\Validation\NotBlankValidator;
use DS3\Framework\Form\Validation\NotNullValidator;
use DS3\Framework\Form\Validation\SequentialArrayValidator;
use DS3\Framework\Form\Validation\SQLFieldValidator;

class QueryFormBuilder implements FormBuilderInterface
{
    /**
     * @return Form
     */
    public function buildForm(&$model)
    {
        $form = new Form($model);

        foreach (array('sensorIdColumn', 'valuesColumn', 'timestampColumn') as $field)
            $form->addField(
                $field,
                array(
                    new SQLFieldValidator(),
                    new NotBlankValidator(),
                    new NotNullValidator()
                ),
                new StringType()
            );

        foreach (array('start', 'end') as $field)
            $form->addField(
                $field,
                array(
                    new GreaterThanValidator(0) // GreaterThan allows null values
                ),
                new DoubleType()
            );

        $form->addField(
            'sensors',
            array(
                new NotNullValidator(),
                new AssociativeArrayValidator(
                    array(
                        new SQLFieldValidator(),
                        new NotBlankValidator(),
                        new NotNullValidator()
                    ),
                    array(
                        new SequentialArrayValidator(array(
                            new NotNullValidator(),
                            new NotBlankValidator()
                        ))
                    )
                )
            ),
            new AssociativeArrayType(
                new StringType(),
                new SequentialArrayType(new IntegerType())
            )
        );

        return $form;
    }
}