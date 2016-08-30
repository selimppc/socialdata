<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/30/16
 * Time: 9:35 AM
 */

namespace App\Models;


class Analysis
{
    protected $table='analysis';
    protected $fillable=[
        'company_id',
        'metric_id',
        'period',
        'data',
    ];
}