<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/10/16
 * Time: 4:23 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $table='post_image';
    protected $fillable=
        [
            'post_id',
            'url',
            'type'
        ];
}