<?php

namespace ExternalUserLog;

use Illuminate\Database\Eloquent\Model;

class ExternalUserLog extends Model 
{

    protected $table = 'external_users_log';
    public $timestamps = true;
    protected $fillable = array('firstname', 'lastname', 'email', 'company', 'phone', 'site_name', 'create_date', 'created_by');

}