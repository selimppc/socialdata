<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 3/2/16
 * Time: 3:46 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $table = 'department';

    protected $fillable = [
        'title','description','slug','status'
    ];
}