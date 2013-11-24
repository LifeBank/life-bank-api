<?php

/**
 * Description of HospitalValidator
 *
 * @author kayfun
 */

namespace App\Services\Validators;

class FaqValidator extends Validator {

    protected $fields = array(
        'title',
        'faq'
    );
    public static $rules = array(
        'title' => 'required',
        'faq' => 'required'
    );

}

?>
