<?php

namespace App\Services\Validators;

abstract class Validator {

    protected $data;
    protected $fields;
    protected $validator;
    public $errors;
    public static $rules;
    public static $messages = array(
        'required' => 'The :attribute field is required.',
        'email' => 'Invalid e-mail address!',
    );

    public function __construct($data = null) {
        $this->data = $data;
        $this->extractData();
    }

    public function passes() {
        $translator = new \Symfony\Component\Translation\Translator('en');
        $factory = new \Illuminate\Validation\Factory($translator);

        $this->validator = $factory->make($this->data, static::$rules, static::$messages);

        if ($this->validator->passes())
            return true;

        return false;
    }

    public function getValidator() {
        return $this->validator;
    }

    public function getData() {
        return $this->data;
    }

    protected function extractData() {
        $raw_data = $this->data;
        $this->data = array();
        foreach ($raw_data as $field => $value) {
            if (in_array($field, $this->fields)) {
                $this->data[$field] = $value;
            }
        }
    }

}

?>