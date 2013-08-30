<?php

/**
 * Description of LoginValidator
 *
 * @author kayfun
 */

namespace App\Services\Validators;

class LoginValidator extends Validator {

    protected $fields = array(       
        'email',        
        'password'
    );
    public static $rules = array(        
        'email' => 'required|email',
        'password' => 'required'
    );

}

?>
