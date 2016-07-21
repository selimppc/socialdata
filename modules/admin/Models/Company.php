<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 7/4/16
 * Time: 10:23 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'title','status','description','created_by'
    ];
    public function relUser(){
        return $this->hasMany('App\User', 'company_id', 'id');
    }
    public function relRole(){
        return $this->hasMany('App\Role', 'company_id', 'id');
    }
}