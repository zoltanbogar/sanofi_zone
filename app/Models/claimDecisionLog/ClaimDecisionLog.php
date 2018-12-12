<?php

namespace ClaimDecisionLog;

use Illuminate\Database\Eloquent\Model;

class ClaimDecisionLog extends Model 
{

    protected $table = 'claim_decisions_log';
    public $timestamps = true;
    protected $fillable = array('user_id', 'claim_id', 'is_approved', 'created_by', 'claim_decision_id');

}