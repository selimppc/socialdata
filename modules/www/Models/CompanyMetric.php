<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/30/16
 * Time: 9:36 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CompanyMetric extends Model
{
    protected $table='company_metrics';
    protected $fillable=[
        'company_id',
        'metric_id'
    ];
    public function relMetric(){
        return $this->belongsTo('App\Models\Metric','metric_id','id');
    }
    public function relCompany(){
        return $this->belongsTo('App\Company','company_id','id');
    }
}