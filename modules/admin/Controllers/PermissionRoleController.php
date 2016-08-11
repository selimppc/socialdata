<?php
#namespace App\Modules\Web\Controllers;
namespace Modules\Admin\Controllers;

use App\Helpers\LogFileHelper;
use App\Permission;
use App\PermissionRole;
use App\Role;
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
use App\Company;

class PermissionRoleController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Permission Role List";

        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin') {
            $data = DB::table('permission_role')
                ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                ->join('role', 'role.id', '=', 'permission_role.role_id')
                ->leftjoin('company','company.id','=','role.company_id')
                ->where('role.type', '!=', 'sadmin')
                ->select('permission_role.id', 'permissions.title as p_title', 'role.title as r_title', 'company.title as company_title', 'permission_role.role_id')
                ->paginate(30);


            $role=  [''=>'Select Role'] +  Role::where('role.type', '!=', 'sadmin')->lists('title','id')->all();
            $company=  [''=>'Select Company'] +  Company::lists('title','id')->all();
            $first_role_id=0;
        }else{
            $data = DB::table('permission_role')
                ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                ->join('role', 'role.id', '=', 'permission_role.role_id')
                ->where('role.type', '!=', 'cadmin')
                ->where('role.company_id', Session::get('company_id'))
                ->select('permission_role.id', 'permissions.title as p_title', 'role.title as r_title', 'permission_role.role_id')
                ->paginate(30);

            $role=  [''=>'Select Role'] +  Role::where('role.type', '!=', 'cadmin')->where('company_id', Session::get('company_id'))->lists('title','id')->all();
            $i=0;
            $first_role_id=0;
            foreach ($role as $id=>$value) {
                $i++;
                if($id != ''){
                    $first_role_id=$id;
                }
                if($i>1){
                    break;
                }
            }
            unset($role[$first_role_id]);
            $company=[];
        }
        /*if($role_id=='sadmin'){
            $permission_id = Permission::where('weight','<=',4)->lists('title','id')->all();
        }elseif($role_id=='admin'){
            $permission_id = Permission::where('weight','<=',3)->lists('title','id')->all();
        }elseif($role_id=='cadmin'){
            $user_role_id= Role::where('type','user')->where('company_id',Session::get('company_id'))->first();
            $user_permitted_role= PermissionRole::select('permission_id')->where('role_id',$user_role_id->id)->get();
            $permitted_id=[];
            foreach ($user_permitted_role as $id => $value) {
                $permitted_id[]=$value->permission_id;
            }

            $permission_id= Permission::whereIn('id',$permitted_id)->lists('title','id')->all();
//            dd($permission_id);
//            $permission_id = Permission::where('weight','<=',2)->lists('title','id')->all();
        }else{
            $permission_id = Permission::where('weight','<=',1)->lists('title','id')->all();
        }*/
        $request= Request();

        if($request->isMethod('post')){

            $role_value = Input::get('role_id');
            $role_name = Role::findOrFail($role_value)->title;
            // whereExists()
            $exists_permission = DB::table('permissions')
                ->whereExists(function ($query) use($role_value){
                    $query->select(DB::raw(1))
                        ->from('permission_role')
                        ->whereRaw('permission_role.permission_id = permissions.id')
                        ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                })
                ->lists('permissions.title', 'permissions.id');

            #print_r($exists_permission);


            //whereNotExists()
            if($role_id=='sadmin'){
                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->where('weight','<=',4)
                    ->lists('permissions.title', 'permissions.id');
            }elseif($role_id=='admin'){
                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->where('weight','<=',3)
                    ->lists('permissions.title', 'permissions.id');
            }elseif($role_id=='cadmin'){
                $user_role_id= Role::where('type','user')->where('company_id',Session::get('company_id'))->first();
                $user_permitted_role= PermissionRole::select('permission_id')->where('role_id',$user_role_id->id)->get();
                $permitted_id=[];
                foreach ($user_permitted_role as $id => $value) {
                    $permitted_id[]=$value->permission_id;
                }

                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->whereIn('id',$permitted_id)
                    ->lists('permissions.title', 'permissions.id');

//                $permission_id= Permission::whereIn('id',$permitted_id)->lists('title','id')->all();
//            dd($permission_id);
//            $permission_id = Permission::where('weight','<=',2)->lists('title','id')->all();
            }else{
                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->where('weight','<=',1)
                    ->lists('permissions.title', 'permissions.id');
            }

            #print_r($not_exists_permission);exit;
            $modal=1;

        }else{
            $not_exists_permission = array();
            $exists_permission = array();
            $role_name = Null;
            $role_value = Null;
            $modal=0;
        }
//        dd($exists_permission);
        return view('admin::permission_role.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'role_id'=>$role,'company'=>$company,'exists_permission' => $exists_permission,'not_exists_permission' => $not_exists_permission,'role_name'=>$role_name,'role_value'=>$role_value,'modal'=>$modal,'first_role_id'=>$first_role_id]);

        //$data = PermissionRole::where('status', '!=', 'cancel')->orderBy('id', 'DESC')->paginate(30);
        #$role_id = [''=>'Select Role'] + Role::lists('title','id')->all();
//        return view('admin::permission_role.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'permission_id'=>$permission_id,'role_id'=>$role,'company'=>$company]);
    }


    public function search_permission_role(){

        $pageTitle = "Permission Role List";

        $r_id=Session::get('role_id');
        $role_id = Input::get('role_id');
        $company_id=Input::get('company_id');
        $permission_name = Input::get('permission_name');
        $data = new PermissionRole();

        $data = $data->select('permission_role.*');
        if($r_id== 'sadmin' || $r_id=='admin') {
            if (isset($role_id) && !empty($role_id)) {
                $data = $data->leftJoin('role', 'role.id', '=', 'permission_role.role_id');
                $data = $data->whereNotIn('role.type', ['sadmin']);
                $data = $data->where('permission_role.role_id', '=', $role_id);
            }
            if (isset($company_id) && !empty($company_id)) {
                $data = $data->leftJoin('role as role_com', 'role_com.id', '=', 'permission_role.role_id');
                $data = $data->where('role_com.company_id', $company_id);
                $data = $data->whereNotIn('role_com.type', ['sadmin']);
            }
            if (isset($permission_name) && !empty($permission_name)) {
                $data = $data->leftJoin('role', 'role.id', '=', 'permission_role.role_id');
                $data = $data->whereNotIn('role.type', ['sadmin']);
                $data = $data->where('company_id', Session::get('company_id'));
                $data = $data->leftJoin('permissions', 'permissions.id', '=', 'permission_role.permission_id');
                $data = $data->where('permissions.title', 'LIKE', '%' . $permission_name . '%');
            }
            $company=  [''=>'Select Company'] +  Company::lists('title','id')->all();
        }else{
            if (isset($role_id) && !empty($role_id)) {
                $data = $data->leftJoin('role', 'role.id', '=', 'permission_role.role_id');
                $data = $data->where('permission_role.role_id', '=', $role_id);
                $data = $data->whereNotIn('role.type', ['sadmin', 'admin']);
            }
            if (isset($permission_name) && !empty($permission_name)) {
                $data = $data->leftJoin('role', 'role.id', '=', 'permission_role.role_id');
                $data = $data->whereNotIn('role.type', ['sadmin', 'admin']);
                $data = $data->where('company_id', Session::get('company_id'));
                $data = $data->leftJoin('permissions', 'permissions.id', '=', 'permission_role.permission_id');
                $data = $data->where('permissions.title', 'LIKE', '%' . $permission_name . '%');
            }
            $company=  [];
        }
        if(empty($permission_name) && empty($role_id) && empty($company_id))
        {
            return $this->index();
        }
        $data = $data->paginate(30);


        if($r_id== 'sadmin' || $r_id=='admin') {
            $role=  [''=>'Select Role'] +  Role::where('role.type', '!=', 'sadmin')->lists('title','id')->all();
            $first_role_id=0;
        }else{
            $role=  [''=>'Select Role'] +  Role::where('role.type', '!=', 'cadmin')->where('company_id', Session::get('company_id'))->lists('title','id')->all();
            $i=0;
            $first_role_id=0;
            foreach ($role as $id=>$value) {
                $i++;
                if($id != ''){
                    $first_role_id=$id;
                }
                if($i>1){
                    break;
                }
            }
            unset($role[$first_role_id]);
            $company=[];
        }
        if($role_id=='sadmin')
        {
            $permission_id = Permission::where('weight','<=',4)->lists('title','id')->all();
        }elseif($role_id=='admin')
        {
            $permission_id = Permission::where('weight','<=',3)->lists('title','id')->all();
        }elseif($role_id=='cadmin')
        {
            $permission_id = Permission::where('weight','<=',2)->lists('title','id')->all();
        }else{
            $permission_id = Permission::where('weight','<=',1)->lists('title','id')->all();
        }

        #$permission_id = Permission::lists('title','id')->all();
        #$role_id = [''=>'Select Role'] + Role::lists('title','id')->all();
        #$role_id =  [''=>'Select Role'] +  Role::where('role.type', '!=', 'sadmin')->lists('title','id')->all();
        return view('admin::permission_role.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'permission_id'=>$permission_id,'role_id'=>$role,'company'=>$company,'first_role_id'=>$first_role_id]);
    }
    public function create(Request $request)
    {

        $pageTitle = "Add Permission Role";

        $role_id=Session::get('role_id');
            $role_value = Input::get('role_id');
            $role_name = Role::findOrFail($role_value)->title;
            // whereExists()
            $exists_permission = DB::table('permissions')
                ->whereExists(function ($query) use($role_value){
                    $query->select(DB::raw(1))
                        ->from('permission_role')
                        ->whereRaw('permission_role.permission_id = permissions.id')
                        ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                })
                ->lists('permissions.title', 'permissions.id');

            #print_r($exists_permission);


            //whereNotExists()
            if($role_id=='sadmin'){
                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->where('weight','<=',4)
                    ->lists('permissions.title', 'permissions.id');
            }elseif($role_id=='admin'){
                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->where('weight','<=',3)
                    ->lists('permissions.title', 'permissions.id');
            }elseif($role_id=='cadmin'){
                $user_role_id= Role::where('type','user')->where('company_id',Session::get('company_id'))->first();
                $user_permitted_role= PermissionRole::select('permission_id')->where('role_id',$user_role_id->id)->get();
                $permitted_id=[];
                foreach ($user_permitted_role as $id => $value) {
                    $permitted_id[]=$value->permission_id;
                }

                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->whereIn('id',$permitted_id)
                    ->lists('permissions.title', 'permissions.id');

//                $permission_id= Permission::whereIn('id',$permitted_id)->lists('title','id')->all();
//            dd($permission_id);
//            $permission_id = Permission::where('weight','<=',2)->lists('title','id')->all();
            }else{
                $not_exists_permission = DB::table('permissions')
                    ->whereNotExists(function ($query) use($role_value){
                        $query->select(DB::raw(1))
                            ->from('permission_role')
                            ->whereRaw('permission_role.permission_id = permissions.id')
                            ->WhereRaw('permission_role.role_id = ?', [$role_value]);
                    })
                    ->where('weight','<=',1)
                    ->lists('permissions.title', 'permissions.id');
            }
        return view('admin::permission_role.create', ['pageTitle'=> $pageTitle, 'role_id'=>$role_id,'exists_permission' => $exists_permission,'not_exists_permission' => $not_exists_permission,'role_name'=>$role_name,'role_value'=>$role_value]);

        //$data = PermissionRole::where('status', '!=', 'cancel')->orderBy('id', 'DESC')->paginate(30);
        #$role_id = [''=>'Select Role'] + Role::lists('title','id')->all();
//        return view('admin::permission_role.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'permission_id'=>$permission_id,'role_id'=>$role,'company'=>$company]);
    }

    public function store(Requests\PermissionRoleRequest $request){
        DB::beginTransaction();
        $input = $request->all();
        $permission_id = $input['permission_id'];
        PermissionRole::where('role_id',$input['role_id'])->delete();
        foreach ($permission_id as $p_id) {
            $permission_exists = PermissionRole::where('permission_id','=',$p_id)->where('role_id','=',$input['role_id'])->exists();
            if(!$permission_exists){
                $model = new PermissionRole;
                $model->role_id = $input['role_id'];
                $model->permission_id = $p_id;
                $model->status = $input['status'];
                /* Transaction Start Here */
                try {
                    $model->save();
                    Session::flash('message', 'Successfully added!');
                    LogFileHelper::log_info('store-permission-role', 'successfully added',  ['Permission role role_id'.$input['role_id']]);
                    DB::commit();
                } catch (\Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    Session::flash('danger', $e->getMessage());
                    LogFileHelper::log_error('store-permission-role', $e->getMessage(),  ['Permission role role_id'.$input['role_id']]);
                }
            }else{
                Session::flash('message','Some of the permission role already exists');
            }
        }
        return redirect()->route('index-permission-role');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'View Permission Role';
        $data = PermissionRole::where('id',$id)->first();
        return view('admin::permission_role.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Update Permission Informations';
        $data = PermissionRole::where('id',$id)->first();
        $permission_id = Permission::lists('title','id');
        $role_id = [''=>'Select Role'] + Role::lists('title','id')->all();
        return view('admin::permission_role.update', ['data' => $data, 'pageTitle'=> $pageTitle, 'permission_id' => $permission_id, 'role_id'=>$role_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\PermissionRoleRequest $request, $id)
    {
        $model = PermissionRole::where('id',$id)->first();
        $input = $request->all();

        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Updated");
            LogFileHelper::log_info('update-permission-role', 'Successfully updated ',  ['Permission role role_id'.$id]);
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            LogFileHelper::log_error('update-permission-role', $e->getMessage(),  ['Permission role role_id'.$id]);
        }
        return redirect()->route('index-permission-role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($pr_ids = Input::get('pr_ids')){
            foreach ($pr_ids as $id) {
                $model = PermissionRole::findOrFail($id);
                DB::beginTransaction();
                try {
                    $model->delete();
                    DB::commit();
                    Session::flash('message', "Successfully Deleted.");
                    LogFileHelper::log_info('delete-permission-role', 'Successfully delete',  ['Permission role role_id'.$id]);

                } catch(\Exception $e) {
                    DB::rollback();
                    Session::flash('danger',$e->getMessage());
                    LogFileHelper::log_error('delete-permission-role', 'Successfully delete.',  ['Permission role role_id'.$id]);
                }
            }
        }else{
            $model = PermissionRole::findOrFail($id);

            DB::beginTransaction();
            try {
                $model->delete();
                DB::commit();
                Session::flash('message', "Successfully Deleted.");
                LogFileHelper::log_info('delete-permission-role', 'Successfully delete ',  ['Permission role role_id'.$id]);
            } catch(\Exception $e) {
                DB::rollback();
                Session::flash('danger',$e->getMessage());
                LogFileHelper::log_error('delete-permission-role', 'Successfully delete ',  ['Permission role role_id'.$id]);
            }
        }
        return redirect()->route('index-permission-role');
    }
}
