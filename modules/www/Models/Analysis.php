<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/30/16
 * Time: 9:35 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $table='analysis';
    protected $fillable=[
        'company_id',
        'metric_id',
        'period',
        'data',
        'status',
    ];
    public function relMetric()
    {
        return $this->belongsTo('App\Models\Metric','metric_id','id');
    }
}