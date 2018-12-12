<?php

namespace ClaimDecision;

use Illuminate\Database\Eloquent\Model;

class ClaimDecision extends Model 
{

    protected $table = 'claim_decisions';
    public $timestamps = true;
    protected $fillable = array('user_id', 'claim_id', 'is_approved', 'create_date', 'modify_date');

    public function user()
    {
        return $this->hasOne('User', 'user_id');
    }

    public function claim()
    {
        return $this->hasOne('Claim', 'claim_id');
    }

}