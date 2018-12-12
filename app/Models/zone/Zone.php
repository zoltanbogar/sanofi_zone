<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Zone extends Model 
{

    protected $table = 'zones';
    public $timestamps = true;
    protected $fillable = array('status', 'create_date', 'modify_date', 'created_by');

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function userManyRelation()
    {
        return $this->belongsToMany(User::class);
    }

    public function claim()
    {
        return $this->belongsToMany('Claim');
    }

}