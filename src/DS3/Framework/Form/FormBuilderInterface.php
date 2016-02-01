<?php

namespace DS3\Framework\Form;

interface FormBuilderInterface
{
    /**
     * @param object $model The model to bind to the form
     *
     * @return Form
     */
    public function buildForm(&$model);
}
