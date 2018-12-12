<?php

namespace SystemVariables;

use Illuminate\Database\Eloquent\Model;

class SystemVariables extends Model 
{

    protected $table = 'system_variables';
    public $timestamps = true;
    protected $fillable = array('key', 'value', 'created_by', 'modified_by', 'create_date', 'modify_date');

}