<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/30/16
 * Time: 2:32 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomPost extends Model
{
    protected $table='custom_posts';
    protected $fillable=[
        'text',
        'status',
        'created_by',
        'updated_by',
    ];
    public function relSchedule()
    {
        return $this->belongsTo('App\Schedule','custom_post_id','id');
    }
    public function relArchiveSchedule()
    {
        return $this->belongsTo('App\ArchiveSchedule','custom_post_id','id');
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