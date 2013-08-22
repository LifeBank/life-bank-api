<?php

namespace App\Services\Validators;

abstract class Validator {

    protected $data;
    protected $fields;
    public $errors;
    public static $rules;

    public function __construct($data = null) {
        $this->data = $data;
        $this->extractData();
    }

    public function passes() {
        $translator = new \Symfony\Component\Translation\Translator('en');
        $factory = new \Illuminate\Validation\Factory($translator);
        
        $validation = $factory->make($this->data, static::$rules);

        if ($validation->passes())
            return true;

        $this->errors = $validation->messages();

        return false;
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