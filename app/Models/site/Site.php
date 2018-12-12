<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model 
{

    protected $table = 'sites';
    public $timestamps = true;
    protected $fillable = array('name', 'parent_id', 'status', 'create_date', 'modify_date', 'created_by');

    public function zone()
    {
        return $this->hasMany('Zone');
    }

}