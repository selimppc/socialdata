<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmType extends Model
{
    protected $table = 'sm_type';
    protected $fillable = [
        'type',
        'access_token',
        'code',
        'status'
    ];

    public static function getDuration($company_id, $sm_type_id = 1)
    {
        $duration = CompanySocialAccount::where('sm_type_id',$sm_type_id)->where('company_id',$company_id)->first();
        return $duration['data_pull_duration'];
    }

    public static function past_time($post_datetime, $number_of_days = 1){
        if($number_of_days == 'all'){
            return true;
        }else{
            $time_between = time() - strtotime($post_datetime);
            $pastTime = 60 * 60 * 24 * $number_of_days;

            if($time_between <= $pastTime){
                return true;
            }
            return false;
        }
    }
    public function relCompanySocialAccount()
    {
        return $this->hasMany('App\CompanySocialAccount','sm_type_id','id');
    }
    public function relPostSocialMedia()
    {
        return $this->hasMany('App\PostSocialMedia','social_media_id','id');
    }
}
