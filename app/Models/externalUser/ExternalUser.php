<?php

namespace ExternalUser;

use Illuminate\Database\Eloquent\Model;

class ExternalUser extends Model 
{

    protected $table = 'external_users';
    public $timestamps = true;
    protected $fillable = array('firstname', 'lastname', 'email', 'create_date', 'modify_date', 'created_by', 'modified_by', 'phone', 'site_name');

    public function claim()
    {
        return $this->belongsTo('Claim');
    }

}