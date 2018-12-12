<?php

namespace BadgeOfficeActionLog;

use Illuminate\Database\Eloquent\Model;

class BadgeOfficeActionLog extends Model 
{

    protected $table = 'badge_office_actions_log';
    public $timestamps = true;
    protected $fillable = array('user_id', 'claim_id', 'is_handled', 'create_date', 'created_by', 'badge_office_action_id');

}