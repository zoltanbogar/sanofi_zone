<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedClaim extends Model 
{

    protected $table = 'rejected_claims';
    public $timestamps = true;
    protected $fillable = array('justification', 'create_date');

    public function claim()
    {
        return $this->hasOne('Claim\Claim', 'claim_id');
    }

}