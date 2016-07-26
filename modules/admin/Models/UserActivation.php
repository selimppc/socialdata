<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 7/26/16
 * Time: 10:41 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    protected $table='user_activation';
    protected $fillable=[
        'user_id',
        'code',
        'expire_date',
        'status',
        'created_at',
        'updated_at'
    ];
}