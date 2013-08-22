<?php

class Location extends Illuminate\Database\Eloquent\Model {

    protected $table = 'location';
    protected $hidden = array('parent_id', 'created_by');

}

?>
