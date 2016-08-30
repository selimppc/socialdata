<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/30/16
 * Time: 12:32 PM
 */

namespace Modules\Www\Controllers;


use App\Http\Controllers\Controller;
use App\Models\CompanyMetric;
use App\Models\Metric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;

class CompanyMetricsController extends Controller
{

    public function analytics_settings()
    {
        $data['pageTitle']='Company Metrics';
        $company_id=session('company_id');
        $data['not_existing_metrics']=$this->_not_existing_metrics($company_id);

        $data['existing_metrics']=$this->_existing_metrics($company_id);
        return view('www::analytics.setting',$data);
    }
    public function store(Request $request)
    {
        $company_id=session('company_id');
        $input=$request->only('selected_id');
        $metrics=Metric::all();

        $existing_metrics=$this->_existing_metrics($company_id);

        $metric_exists=[];
        $existing_metrics_array=[];
        foreach ($existing_metrics as $existing_metric) {
            $existing_metrics_array[]=$existing_metric->id;
            foreach ($input['selected_id'] as $item) {
                if($item==$existing_metric->id)
                {
                    $metric_exists[]=$item;
                }
            }
        }
        $metric_new=array_merge(array_diff($input['selected_id'],$metric_exists),array_diff($metric_exists,$input['selected_id']));
//        echo '<pre>';print_r($input['selected_id']);
//        echo '<pre>';print_r($existing_metrics_array);
//        echo '<pre>';print_r($metric_exists);
//        echo '<pre>';print_r($metric_new);
        $diff_between_exist_input=array_merge(array_diff($input['selected_id'],$existing_metrics_array),array_diff($existing_metrics_array,$input['selected_id']));
//        echo '<pre>';print_r($diff_between_exist_input);
        $to_delete=array_merge(array_diff($metric_new,$diff_between_exist_input),array_diff($diff_between_exist_input,$metric_new));
//        dd($to_delete);
        DB::beginTransaction();
        try {
            if (isset($metric_new) && !empty($metric_new)) {
                foreach ($metric_new as $metric_id) {
                    $companyMetric = new CompanyMetric();
                    $companyMetric->company_id = $company_id;
                    $companyMetric->metric_id = $metric_id;
                    $companyMetric->save();
                }
            }
            if (isset($to_delete) && !empty($to_delete)) {
                foreach ($to_delete as $metric_id) {
                    CompanyMetric::where('metric_id', $metric_id)->where('company_id', $company_id)->delete();
                }
            }
            DB::commit();
            Session::flash('message','Successfully updated metrics');
        }catch (Exception $e)
        {
            DB::rollback();
            Session::flash('error',$e->getMessage());
        }
        return redirect()->back();
    }
    private function _not_existing_metrics($company_id){
        return DB::table('metrics')
            ->select('metrics.id','metrics.name','metrics.options')
            ->leftJoin('company_metrics',function ($join) use($company_id)
            {
                $join->on('metrics.id','=','company_metrics.metric_id')->where('company_id','=',$company_id);
            })
            ->where('company_metrics.id','=',null)
            ->get();
    }
    private function _existing_metrics($company_id)
    {
        return DB::table('company_metrics')
            ->select('metrics.id','metrics.name','metrics.options')
            ->leftJoin('metrics','company_metrics.metric_id','=','metrics.id')
            ->where('company_metrics.company_id','=',$company_id)
            ->get();
    }
}