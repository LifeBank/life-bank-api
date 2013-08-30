<?php

/**
 * Description of UpdateValidator
 *
 * @author kayfun
 */

namespace App\Services\Validators;

class UpdateValidator extends Validator {

    protected $fields = array(
        'first_name',
        'last_name',
        'phone_number',
        'location',
        'blood_group'
    );
    public static $rules = array(
        'first_name' => 'required|min:5',
        'last_name' => 'required|min:5',
        'phone_number' => 'required',
        'location' => 'required',
        'blood_group' => 'required'
    );

}

?>
