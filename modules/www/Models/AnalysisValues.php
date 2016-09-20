<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 9/20/16
 * Time: 10:24 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AnalysisValues extends Model
{
    protected $table = 'analysis_values';
    protected $fillable=[
        'analysis_id',
        'value',
        'end_time',
    ];
}