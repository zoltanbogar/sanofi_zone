<?php

namespace ApprovedClaim;

use Illuminate\Database\Eloquent\Model;

class ApprovedClaim extends Model 
{

    protected $table = 'approved_claims';
    public $timestamps = true;
    protected $fillable = array('claim_id');

    public function claim()
    {
        return $this->hasOne('Claim\Claim', 'claim_id');
    }

}