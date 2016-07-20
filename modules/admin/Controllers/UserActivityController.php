<?php
/**
 * Created by PhpStorm.
 * User: selim
 * Date: 3/2/16
 * Time: 4:25 PM
 */

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\UserActivity;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\RoleUser;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Session;

class UserActivityController extends Controller
{


    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }


    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "User Activity ";

        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin') {
            $data= DB::table('user_activity')
                ->leftJoin('user', 'user.id', '=', 'user_activity.user_id')
                ->select('user_activity.*','user.username')
                ->orderBy('user_activity.id', 'DESC')->paginate(30);
            $user_list = User::lists('username', 'id');
        }else{
            $data= DB::table('user_activity')
                ->leftJoin('user', 'user.id', '=', 'user_activity.user_id')
                ->where('user.company_id',Session::get('company_id'))
                ->select('user_activity.*','user.username')
                ->orderBy('user_activity.id', 'DESC')->paginate(30);
//            $data = UserActivity::leftJoin('user', 'user.id', '=', 'user_id')
//                ->orderBy('id', 'DESC')->paginate(30);
//            dd($data);
            $user_list = User::where('company_id',Session::get('company_id'))->lists('username', 'id');
        }

        return view('admin::user_activity.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'user_list'=> $user_list,
        ]);
    }



    public function search_user_activity(){
        $pageTitle = "User Activity by";
        $data = new UserActivity();

        $role_id=Session::get('role_id');
        if($this->isGetRequest()){
            $action_name = Input::get('action_name');
            $action_route = Input::get('action_route');
            $in_date = Input::get('date');
            $user_id = Input::get('user_id');
            $in_date= explode(" ",$in_date);
            $in_date=date('Y-m-d',strtotime($in_date[0]));

            $data = $data->select('user_activity.*','user.username');
            if($action_name){
                $data = $data->where('user_activity.action_name', 'LIKE','%'.$action_name.'%');
            }
            if($action_route){
                $data = $data->where('user_activity.action_url', 'LIKE', '%'.$action_route.'%');
            }
            if($in_date){
                $data = $data->whereDate('user_activity.date', '=', $in_date);
            }
            if(isset($user_id) && !empty($user_id)){
                $data = $data->where('user_activity.user_id', '=', $user_id);
            }
            if($role_id!= 'sadmin' && $role_id!='admin') {
                $data= $data->leftJoin('user', 'user.id', '=', 'user_activity.user_id')
                    ->where('user.company_id',Session::get('company_id'));
            }else{
                $data= $data->leftJoin('user', 'user.id', '=', 'user_activity.user_id');
            }

            $data = $data->orderBy('user_activity.id', 'DESC')->paginate(30);
            /*$data = $data->orderBy('user_activity.id', 'DESC')->toSql();
            dd($data); exit;*/
        }else{
            return $this->index();
        }

        if($role_id== 'sadmin' || $role_id=='admin') {
            $user_list = User::lists('username', 'id');
        }else{
            $user_list = User::where('company_id',Session::get('company_id'))->lists('username', 'id');
        }

        return view('admin::user_activity.index', [
            'data' => $data,
            'pageTitle'=> $pageTitle,
            'user_list'=> $user_list,

        ]);
    }


}