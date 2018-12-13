<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model 
{

    protected $table = 'claims';
    public $timestamps = true;
    protected $fillable = array('is_external_target', 'authorized_from', 'authorized_to', 'status', 'is_draft', 'claim_date', 'create_date');

    public function claimer()
    {
        return $this->hasOne('User', 'claimer_user_id');
    }

    public function target()
    {
        return $this->hasOne('User', 'target_user_id');
    }

    public function zone()
    {
        return $this->hasOne('Zone', 'zone_id');
    }

    public function approved_claim()
    {
        return $this->belongsTo('ApprovedClaim');
    }

    public function rejected_claim()
    {
        return $this->belongsTo('RejectedClaim');
    }

    public function claim_decision()
    {
        return $this->belongsTo('ClaimDecision');
    }

    public function external_user()
    {
        return $this->hasOne('ExternalUser', 'target_user_id');
    }

    public function badge_office_action()
    {
        return $this->belongsTo('BadgeOfficeAction');
    }

}