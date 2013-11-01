<?php

/**
 * Description of HospitalValidator
 *
 * @author kayfun
 */

namespace App\Services\Validators;

class HospitalValidator extends Validator {

    protected $fields = array(
        'hospital_name',
        'address',
        'phone_numbers'
    );
    public static $rules = array(
        'hospital_name' => 'required',
        'address' => 'required'
    );

}

?>
