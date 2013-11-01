<?php

class Hospital extends Illuminate\Database\Eloquent\Model {

    protected $table = 'hospital';
    protected $fillable = array('hospital_name', 'address', 'phone_numbers');
    
      public function locations() {
        return $this->belongsToMany('Location', 'hospital_location', 'hospital_id', 'location_id');
    }
}

?>
