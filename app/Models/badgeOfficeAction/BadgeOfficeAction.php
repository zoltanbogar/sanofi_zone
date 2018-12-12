<?php

namespace BadgeOfficeAction;

use Illuminate\Database\Eloquent\Model;

class BadgeOfficeAction extends Model 
{

    protected $table = 'badge_office_actions';
    public $timestamps = true;
    protected $fillable = array('user_id', 'claim_id', 'is_seen', 'is_handled', 'create_date', 'modify_date');

    public function user()
    {
        return $this->hasOne('User', 'user_id');
    }

    public function claim()
    {
        return $this->hasOne('Claim', 'claim_id');
    }

}