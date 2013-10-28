<?php

/**
 * Description of SignupValidator
 *
 * @author kayfun
 */

namespace App\Services\Validators;

class SignupValidator extends Validator {

    protected $fields = array(
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'location',
        'blood_group',
        'image_path',
        'username'
    );
    public static $rules = array(
        'first_name' => 'required|min:1',
        'last_name' => 'required|min:1',
        'email' => 'required|email',
        'phone_number' => 'required',
        'location' => 'required',
        'blood_group' => 'required'
    );

}

?>
