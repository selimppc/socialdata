<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/30/16
 * Time: 9:36 AM
 */

namespace App\Models;


class CompanyMetric
{
    protected $table='company_metrics';
    protected $fillable=[
        'company_id',
        'metric_id'
    ];
}