<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/30/16
 * Time: 2:35 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchiveSchedule extends Model
{
    protected $table= 'archive_schedule';
    protected $fillable= [
        'custom_post_id',
        'time',
        'schedule_created_by',
        'schedule_updated_by',
        'schedule_created_at',
        'schedule_updated_at',
    ];
    public function relCustomPost()
    {
        return $this->belongsTo('App\CustomPost','custom_post_id','id');
    }

}