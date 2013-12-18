<?php

/**
 * Description of UserHospital
 *
 * @author kayfun
 */
class UserHospital extends Illuminate\Database\Eloquent\Model {

    protected $fillable = array('user_id', 'hospital_id');
    protected $table = 'user_hospital';

}
