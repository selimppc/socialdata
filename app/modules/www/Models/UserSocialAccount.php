<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 2:00 PM
 */

namespace App\Modules\Www\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialAccount extends Model
{
    protected $table='user_social_account';
    protected $fillable=[
        'sm_account_id',
        'user_id',
        'sm_type_id',
        'data_pull_duration',
        'status'
    ];
    public function relSmType()
    {
        return $this->belongsTo('App\relSmType','sm_account_id','id');
    }
}