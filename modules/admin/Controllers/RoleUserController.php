<?php
#namespace App\Modules\Web\Controllers;
namespace Modules\Admin\Controllers;

use App\Helpers\LogFileHelper;
use App\Permission;
use App\PermissionRole;
use App\Role;
use App\RoleUser;
use App\User;
use App\UserResetPassword;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RoleUserController extends Controller
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
        $pageTitle = "Role User Information";

        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin') {
            $data = DB::table('role_user')
                ->join('user', 'user.id', '=', 'role_user.user_id')
                ->join('role', 'role.id', '=', 'role_user.role_id')
                ->where('role.type', '!=', 'sadmin')
                ->select('role_user.id', 'user.username', 'user.email', 'role.title')
                ->paginate(30);
            $user_id = [''=>'Select User'] + User::where('id','!=',Session::get('user_id'))->lists('username','id')->all();

            $role =  [''=>'Select Role'] +  Role::where('role.type', '!=', 'sadmin')->lists('title','id')->all();
        }else{
            $data = DB::table('role_user')
                ->join('user', 'user.id', '=', 'role_user.user_id')
                ->join('role', 'role.id', '=', 'role_user.role_id')
//                ->where('role.type', '!=', 'cadmin')
                ->where('user.company_id', Session::get('company_id'))
                ->select('role_user.id', 'user.username', 'user.email', 'role.title')
                ->paginate(30);
            $user_id = [''=>'Select User'] + User::where('id','!=',Session::get('user_id'))->where('user.company_id', Session::get('company_id'))->lists('username','id')->all();

            $role =  [''=>'Select Role'] +  Role::where('role.company_id', Session::get('company_id'))->lists('title','id')->all();
        }
        /*$data = new RoleUser();
        $data = $data->join('role','role.id','=','role_id');
        $data = $data->join('user','user.id','=','user_id');
        if(isset($role_name) && !empty($role_name)){
            $data = $data->where('role.title', 'LIKE', '%'.$role_name.'%');
        }
        if(isset($username) && !empty($username)){
            $data = $data->where('user.username', 'LIKE', '%'.$username.'%');
        }
        $data = $data->paginate(30);*/

        return view('admin::role_user.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'user_id'=>$user_id,'role_id'=>$role]);
    }

    public function search_role_user(){

        $role_id_session=Session::get('role_id');
        $pageTitle = "Role User Informations";

        if($this->isGetRequest()){
            $role_id = Input::get('role_id');
            $username = Input::get('username');
            if(empty($role_id) && empty($username))
            {
                return $this->index();
            }else {
                $data = new RoleUser();

                $data = $data->select('role_user.*');
                if (isset($role_id) && !empty($role_id)) {
                    $data = $data->leftJoin('role', 'role.id', '=', 'role_user.role_id');
                    $data = $data->where('role.type', '!=', 'sadmin');
                    if ($role_id_session != 'sadmin' && $role_id_session != 'admin') {
                        $data = $data->where('role.company_id', Session::get('company_id'));
                    }
                    $data = $data->where('role_user.role_id', '=', $role_id);
                }
                if (isset($username) && !empty($username)) {
                    $data = $data->leftJoin('user', 'user.id', '=', 'role_user.user_id');
                    $data = $data->where('user.username', 'LIKE', '%' . $username . '%');
                    if ($role_id_session != 'sadmin' && $role_id_session != 'admin') {
                        $data = $data->where('user.company_id', Session::get('company_id'));
                    }
                }
                $data = $data->paginate(30);
            }
        }else{
            $data = DB::table('role_user')
                ->join('user', 'user.id', '=', 'role_user.user_id')
                ->join('role', 'role.id', '=', 'role_user.role_id')
                ->where('role.type', '!=', 'sadmin')
                ->select('role_user.id', 'user.username','user.email', 'role.title')
                ->paginate(30);
        }
//        dd($data);
        #$user_id = [''=>'Select User'] + User::lists('username','id')->all();

        #$role_id = [''=>'Select Role'] +  Role::where('role.type', '!=', 'sadmin')->lists('title','id')->all();



        if($role_id_session== 'sadmin' || $role_id_session=='admin') {
            $user_id = [''=>'Select User'] + User::where('id','!=',Session::get('user_id'))->lists('username','id')->all();

            $role =  [''=>'Select Role'] +  Role::where('role.type', '!=', 'sadmin')->lists('title','id')->all();
        }else{
            $user_id = [''=>'Select User'] + User::where('id','!=',Session::get('user_id'))->where('user.company_id', Session::get('company_id'))->lists('username','id')->all();

            $role =  [''=>'Select Role'] +  Role::where('role.company_id', Session::get('company_id'))->lists('title','id')->all();
        }
        return view('admin::role_user.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'user_id'=>$user_id,'role_id'=>$role]);
    }

    public function store(Requests\RoleUserRequest $request){
        $input = $request->all();
        $role_user_exists = RoleUser::where('user_id',$input['user_id'])->exists();
        if(!$role_user_exists){
            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                RoleUser::create($input);
                DB::commit();
                Session::flash('message', 'Successfully added!');
                LogFileHelper::log_info('store-role-user', 'Successfully added', ['Role user (user_id): '.$input['user_id']]);
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                Session::flash('danger', $e->getMessage());
                LogFileHelper::log_error('store-role-user', $e->getMessage(), ['Role user (user_id): '.$input['user_id']]);
            }

        }else{
            Session::flash('danger','User role already exists.');
        }
        return redirect()->route('index-role-user');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'View Role User Informations';
        $data = RoleUser::where('id',$id)->first();

        return view('admin::role_user.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Update Role User Informations';
        $data = RoleUser::where('id',$id)->first();

        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin') {
            $user_id = [''=>'Select User'] + User::where('id','!=',Session::get('user_id'))->lists('username','id')->all();

            $role =  [''=>'Select Role'] +  Role::where('role.type', '!=', 'sadmin')->lists('title','id')->all();
        }else{
            $user_id = [''=>'Select User'] + User::where('id','!=',Session::get('user_id'))->where('user.company_id', Session::get('company_id'))->lists('username','id')->all();

            $role =  [''=>'Select Role'] +  Role::where('role.company_id', Session::get('company_id'))->lists('title','id')->all();
        }

//        $user_id = User::lists('username','id');
//        $role_id = Role::lists('title','id');
        return view('admin::role_user.update', ['data' => $data, 'pageTitle'=> $pageTitle, 'user_id' => $user_id, 'role_id'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\RoleUserRequest $request, $id)
    {
        $model = RoleUser::where('id',$id)->first();
        $input = $request->all();
        DB::beginTransaction();
        try {
            $model->update($input);
            $user= User::where('id',$input['user_id'])->first();
            $user->role_id=$input['role_id'];
            $user->save();
            DB::commit();
            Session::flash('message', "Successfully Updated");
            LogFileHelper::log_info('update-role-user', 'Successfully Updated', ['Role-user id: '.$model->id]);
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            LogFileHelper::log_error('update-role-user', $e->getMessage(), ['Role-user id: '.$model->id]);
        }
        return redirect()->route('index-role-user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = RoleUser::findOrFail($id);

        DB::beginTransaction();
        try {
            if($model->status =='active'){
                $model->status = 'cancel';
            }else{
                $model->status = 'active';
            }
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
            LogFileHelper::log_info('delete-role-user', 'Successfully update status cancel', ['Role-user id: '.$model->id]);

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
            LogFileHelper::log_error('delete-role-user', $e->getMessage(), ['Role-user id: '.$model->id]);
        }
        return redirect()->route('index-role-user');
    }
}