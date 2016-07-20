<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/5/16
 * Time: 5:30 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostSocialMedia extends Model
{
    protected $table='post_social_media';
    protected $fillable=[
        'custom_post_id',
        'social_media_id',
        'status',
        'postId',
    ];
    public function relCustomPost()
    {
        return $this->belongsTo('App\CustomPost','custom_post_id','id');
    }
    public function relSmType()
    {
        return $this->belongsTo('App\relSmType','social_media_id','id');
    }

}