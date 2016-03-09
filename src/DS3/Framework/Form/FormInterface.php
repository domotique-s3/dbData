<?php

namespace DS3\Framework\Form;

interface FormInterface
{
    /**
     * @param array [string]mixed $data
     */
    public function submit(array $data);

    /**
     * @return bool
     */
    public function isSubmitted();

    /**
     * @return array[string]mixed
     */
    public function getErrors();
}
