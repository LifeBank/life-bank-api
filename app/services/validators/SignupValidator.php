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
        'email_address',
        'phone_number',
        'gender',
        'date_of_birth',
        'location',
        'password',
        'blood_group',
        'status'
    );
    public static $rules = array(
        'first_name' => 'required|min:5',
        'first_name' => 'required|min:5',
        'email_address' => 'required|email',
        'phone_number' => 'required',
        'gender' => 'required',
        'date_of_birth' => 'required',
        'location' => 'required',
        'password' => 'required',
        'blood_group' => 'required',
        'status' => 'required'
    );

}

?>
