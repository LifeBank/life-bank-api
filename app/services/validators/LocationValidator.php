<?php

/**
 * Description of LocationValidator
 *
 * @author kayfun
 */

namespace App\Services\Validators;

class LocationValidator extends Validator {

    protected $fields = array(
        'location',
        'short_name',
        'state_id',
        'parent_id'
    );
    public static $rules = array(
        'location' => 'required',
        'short_name' => 'required',
        'state_id' => 'required',
        'parent_id' => 'required',
        'location' => 'required'
    );

}

?>
