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
        'location_id',
        'blood_group',
        'image_path',
        'username',
        'user_hospitals'
    );
    public static $rules = array(
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'location_id' => 'required',
        'blood_group' => 'required'
    );

}

?>
