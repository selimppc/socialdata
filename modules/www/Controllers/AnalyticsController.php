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

class AnalyticsController extends Controller
{
    public function get_analytics()
    {
        $company_social_accounts=CompanySocialAccount::where('sm_type_id',2)->where('sm_account_id','!=','')->get();
//        dd($company_social_accounts);
        $i=0;
        foreach ($company_social_accounts as $company_social_account) {
            print ++$i.". Facebook Account Found \n";
            $data=FacebookHelper::metric($company_social_account->access_token,$company_social_account->page_id);
            dd($data);
            $data=$data->getDecodedBody('data');
//            dd($data['data']);
            FacebookHelper::storeData($data['data'],$company_social_account);
        }
    }
    public function analytics_settings()
    {
        
    }
}