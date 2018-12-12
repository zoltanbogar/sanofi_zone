<?php

namespace ZoneLog;

use Illuminate\Database\Eloquent\Model;

class ZoneLog extends Model 
{

    protected $table = 'zones_log';
    public $timestamps = true;
    protected $fillable = array('name', 'site_id', 'status', 'create_date', 'created_by');

}