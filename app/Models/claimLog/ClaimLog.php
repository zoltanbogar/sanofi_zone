<?php

namespace ClaimLog;

use Illuminate\Database\Eloquent\Model;

class ClaimLog extends Model 
{

    protected $table = 'claims_log';
    public $timestamps = true;
    protected $fillable = array('target_user_id', 'is_external_target', 'zone_id', 'authorized_from', 'authorized_to', 'status', 'is_draft', 'claim_date', 'create_date', 'claim_id');

}