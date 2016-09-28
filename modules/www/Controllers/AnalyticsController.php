<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/29/16
 * Time: 10:22 AM
 */

namespace Modules\Www\Controllers;


use App\CompanySocialAccount;
use App\Helpers\FacebookHelper;
use App\Http\Controllers\Controller;
use App\Models\Analysis;
use App\Models\CompanyMetric;
use App\Models\Metric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $request=$request->all();
        $data['pageTitle']='Analytics';
        $company_id=session('company_id');
        $data['per_page']=500;
        if(isset($request['metric_name']))
        {
            $data['analytics']=Analysis::with('relMetric')->where('company_id',$company_id)->where('status',1)->paginate($data['per_page']);
        }elseif(isset($request['date']))
        {
            $data['analytics']=Analysis::with('relMetric')->where('company_id',$company_id)
                ->where('end_time','like',$request['date'].'%')->where('status',1)->paginate($data['per_page']);
//            dd($data);
        }else{
            $data['analytics']=Analysis::with('relMetric')->where('company_id',$company_id)->where('status',1)->paginate($data['per_page']);
        }
//        dd($data);
        return view('www::analytics.index',$data);
    }
    public function get_analytics()
    {
        $company_social_accounts=CompanySocialAccount::where('sm_type_id',2)->where('sm_account_id','!=','')->get();
//        dd($company_social_accounts);
        $i=0;
        foreach ($company_social_accounts as $company_social_account) {
            print ++$i.". Facebook Account Found \n";
            $data=FacebookHelper::metric($company_social_account->access_token,$company_social_account->page_id,$company_social_account->company_id);
//            dd($data);
//            $data=$data->getDecodedBody('data');
//            dd($data['data']);
//            FacebookHelper::storeData($data['data'],$company_social_account);
        }
    }
}