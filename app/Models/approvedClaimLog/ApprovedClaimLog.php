<?php

namespace ApprovedClaimLog;

use Illuminate\Database\Eloquent\Model;

class ApprovedClaimLog extends Model 
{

    protected $table = 'approved_claims_log';
    public $timestamps = true;
    protected $fillable = array('create_date', 'approved_claims_id');

}