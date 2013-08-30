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
        'password',
        'blood_group',
        'image_path'
    );
    public static $rules = array(
        'first_name' => 'required|min:5',
        'last_name' => 'required|min:5',
        'email' => 'required|email',
        'phone_number' => 'required',
        'location' => 'required',
        'password' => 'required',
        'blood_group' => 'required'
    );

}

?>
