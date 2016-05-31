<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $fillable = [
        'name',
        'status'
    ];

    public function relCustomPost()
    {
        return $this->hasMany('App\CustomPost','company_id','id');
    }
    public function relUser(){
        return $this->hasMany('App\User', 'company_id', 'id');
    }
}
