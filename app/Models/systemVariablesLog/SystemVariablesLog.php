<?php

namespace SystemVariablesLog;

use Illuminate\Database\Eloquent\Model;

class SystemVariablesLog extends Model 
{

    protected $table = 'system_variables_log';
    public $timestamps = true;
    protected $fillable = array('key', 'value', 'create_date', 'created_by');

}