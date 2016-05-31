<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/30/16
 * Time: 10:17 AM
 */

namespace App\Modules\Www\Controllers;

use App\Http\Controllers\Controller;
use App\Company;
use App\User;
use Illuminate\Http\Request;

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
}