<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/29/16
 * Time: 12:57 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    protected $table='metrics';
    protected $fillable=[
        'name',
        'options'
    ];
}