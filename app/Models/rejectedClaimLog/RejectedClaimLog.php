<?php

namespace RejectedClaimLog;

use Illuminate\Database\Eloquent\Model;

class RejectedClaimLog extends Model 
{

    protected $table = 'rejected_claims_log';
    public $timestamps = true;
    protected $fillable = array('justification', 'create_date', 'rejected_claim_id');

}