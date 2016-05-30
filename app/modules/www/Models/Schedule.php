<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/30/16
 * Time: 2:34 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table= 'schedule';
    protected $fillable= [
        'custom_post_id',
        'time',
        'created_by',
        'updated_by',
    ];

    public function relCustomPost()
    {
        return $this->belongsTo('App\CustomPost','custom_post_id','id');
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