<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySocialAccount extends Model
{
    protected $table = 'company_social_account';
    protected $fillable = [
        'sm_account_id',
        'company_id',
        'sm_type_id',
        'data_pull_duration',
        'status'
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
