<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $fillable = [
        'post_id',
        'comment_id',
        'comment',
        'comment_date'
    ];

    //Relation with company table
    public function relPost(){
        return $this->belongsTo('App\Post', 'post_id', 'id');
    }
}
