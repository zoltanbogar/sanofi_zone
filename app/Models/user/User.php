<?php

namespace App;

use App\Zone;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UserAdmin;
use App\Models\Traits\UserHelper;
use App\Models\Traits\UserRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, UserHelper, UserRoles, UserAdmin;

    protected $appends = ['fullname'];

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = array('firstname', 'lastname', 'company', 'site_name', 'email', 'phone', 'status');

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'firstname' => 'required',
        'lastname'  => 'required',
        'gender'    => 'required|in:male,female',
        'email'     => 'required|email|unique:users',
        'password'  => 'required|min:4|confirmed',
        'token'     => 'required|exists:user_invites,token',

        //'cellphone' => 'required|min:3:max:255',
        //'photo'     => 'required|image|max:6000|mimes:jpg,jpeg,png,bmp',
    ];

    /**
     * Validation rules for this model
     */
    static public $rulesProfile = [
        'firstname' => 'required',
        'lastname'  => 'required',
        'gender'    => 'required|in:male,female',
        'photo'     => 'required|image|max:6000|mimes:jpg,jpeg,png,bmp',
    ];

    public function zone()
    {
        return $this->belongsToMany(Zone::class);
    }

    public function claimer()
    {
        return $this->belongsTo('Claim');
    }

    public function target()
    {
        return $this->belongsTo('User');
    }

    public function claim_decision()
    {
        return $this->belongsTo('ClaimDecision');
    }

    public function badge_office_action()
    {
        return $this->belongsTo('BadgeOfficeAction');
    }

}