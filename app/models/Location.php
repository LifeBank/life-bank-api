<?php

class Location extends Illuminate\Database\Eloquent\Model {

    protected $table = 'location';
    protected $hidden = array('parent_id');
    protected $fillable = array('state_id', 'parent_id', 'short_name', 'location');

    public function hospitals() {
        return $this->belongsToMany('Hospital', 'hospital_location', 'location_id', 'hospital_id');
    }

    public function parent() {
        return $this->belongsTo('Location', 'parent_id');
    }

    public function state() {
        return $this->belongsTo('State');
    }
    
    public function delete() {
        HospitalLocation::where("location_id", $this->id)->delete();
        return parent::delete();
    }

}

?>
