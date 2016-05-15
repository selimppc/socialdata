<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';
    protected $fillable = [
        'name',
        'email',
        'company_id',
        'sm_type_id',
        'post_date',
        'post_update',
        'post'
    ];

    //Relation with company table
    public function relCompany(){
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    //Relation with sm_type table
    public function relSmtype(){
        return $this->belongsTo('App\SmType', 'sm_type_id', 'id');
    }
}
