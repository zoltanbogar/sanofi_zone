<?php

namespace SiteLog;

use Illuminate\Database\Eloquent\Model;

class SiteLog extends Model 
{

    protected $table = 'sites_log';
    public $timestamps = true;
    protected $fillable = array('name', 'parent_id', 'create_date', 'created_by', 'status');

}