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
        'location_id',
        'blood_group',
        'user_hospitals'
    );
    public static $rules = array(
        'first_name' => 'required',
        'last_name' => 'required',
        'phone_number' => 'required',
        'location_id' => 'required',
        'blood_group' => 'required'
    );

}

?>
