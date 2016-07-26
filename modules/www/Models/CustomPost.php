<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/30/16
 * Time: 2:32 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class CustomPost extends Model
{
    protected $table='custom_posts';
    protected $fillable=[
        'text',
        'status',
        'company_id',
        'notify_time',
        'execute_time',
        'postId',
        'created_by',
        'updated_by',
    ];
    public function relUser()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
    public function relSchedule()
    {
        return $this->hasOne('App\Schedule','custom_post_id','id');
    }
    public function relArchiveSchedule()
    {
        return $this->hasOne('App\ArchiveSchedule','custom_post_id','id');
    }
    public function relCompany()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }
    public function relPostSocialMedia()
    {
        return $this->hasMany('App\PostSocialMedia','custom_post_id','id');
    }




    // TODO :: boot
    // boot() function used to insert logged user_id at 'created_by' & 'updated_by'

    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = Auth::user()->id;
            }
        });
    }

}