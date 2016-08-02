<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/30/16
 * Time: 10:17 AM
 */

namespace Modules\Www\Controllers;

use App\CustomPost;
use App\Http\Controllers\Controller;
use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class SettingController extends Controller
{
    public function select_company()
    {
        $data['pageTitle'] = 'Select Your Company';
        $data['company']= Company::where('status','active')->lists('name','id')->all();
        return view('www::setting.select_company',$data);
    }
    public function store_company(Request $request)
    {
        $user= User::findOrFail(\Auth::user()->id);
        $user->company_id= $request->input('company_id');
        $user->save();
        \Session::flash('message', 'Your Company has been updated successfully');
        return redirect()->back();
    }
    public function main_search(Request $request)
    {
        $company_id=session('company_id');
        $data['pageTitle']='Search Posts';

        $text = $request->all();
        $search = new CustomPost();
        $search = $search->where('text', 'like', '%' . $text['headerSearch'] . '%');
//        $search = $search->paginate(10);

        if(session('role_id')=='user')
        {
            $search=$search->with(['relSchedule','relCompany'=>function($query){
                $query->addSelect('id','title');
            }])->where('company_id',$company_id)->where('created_by',session('user_id'));
        }elseif($company_id != null){
            $search=$search->with(['relSchedule','relCompany'=>function($query){
                $query->addSelect('id','title');
            }])->where('company_id',$company_id);
        }else{
            $search=$search->with(['relSchedule','relCompany'=>function($query){
                $query->addSelect('id','title');
            }]);
        }
        $data['posts']=$search->paginate(10);
        return view('www::custom_post.index',$data);
    }
}