<?php
#namespace App\Modules\Web\Controllers;
namespace Modules\Admin\Controllers;


use App\Helpers\LogFileHelper;
use App\Permission;
use App\PermissionRole;
use App\RoleUser;
use App\UserActivity;
use App\UserImage;
use Mockery\CountValidator\Exception;
use Validator;
use App\Country;
use App\Helpers\ImageResize;
use App\Role;
use App\User;
use App\UserMeta;
use App\UserProfile;
use App\UserResetPassword;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Auth;
use DateTime;
use App\Company;

class UserController extends Controller
{

    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }
    public function create_sign_up()
    {
        $data['pageTitle']='Sign Up';
        return view('admin::signup._form',$data);
    }
    public function store_signup_info(Requests\UserRequest $request)
    {

        $input = $request->all();

        #print_r($input);exit;

        $input_company = [
            'title'=>$input['title'],
            'status'=>'active',
            'description'=>$input['description'],
            'created_by'=>1
        ];
        $company_name=str_replace(' ','-',$input['title']);
        DB::beginTransaction();
        try{

            $company_exists = DB::table('company')->where('title', '=', $input['title'])->exists();

            if($company_exists){

                //$company_ids = DB::table('company')->where('title', '=', $input['title'])->first();
                //$company_id = $company_ids->id;
                Session::flash('message', 'Sorry,This company is already exist. Please try with new one.');
                return redirect()->back();
            }else{
                $company_ids = Company::create($input_company);
                $company_id = $company_ids->id;
            }

            $input_role = [
                'title'=>$input['title'].' | Com. Admin',
                'slug'=>strtolower($company_name.'-cadmin'),
                'status'=>'active',
                'company_id'=>$company_id,
                'type'=>'cadmin',
                'created_by'=>1,
            ];
            $role_exists = DB::table('role')->where('slug', '=', 'com-admin')->where('company_id', '=', $company_id)->exists();
            if($role_exists){
                Session::flash('message', 'This Company Admin already exists');
                return redirect()->back();
            }else{
                $role_ids = Role::create($input_role);
                $role_id = $role_ids->id;
            }

            #print_r($role_id);exit;

            $curr_date = date('Y-m-d h:i:s', time());
            $date= date('Y-m-d h:i:s', strtotime($curr_date. ' + 180 days'));

            $input_data = [
                'username'=>$input['username'],
                'email'=>$input['email'],
                'password'=>Hash::make($input['password']),
                #'auth_key'=>'',
                #'access_token'=>str_random(30),
                'csrf_token'=> str_random(30),
                'ip_address'=> getHostByName(getHostName()),
                #'last_visit'=> date('Y-m-d h:i:s', time()),
                'company_id'=> $company_id,
                'role_id'=> $role_id,
                'last_visit'=> date('Y-m-d h:i:s', time()),
                'expire_date'=> $date,
                'status'=> 'register',
                'remember_token'=> str_random(30),
                'created_by'=> 1
            ];

            $user_id = User::create($input_data);

            $input_role_user = [
                'role_id'=>$role_id,
                'user_id'=>$user_id->id,
                'status'=>'active',
                'created_by'=>1
            ];
            RoleUser::create($input_role_user);
            // Give permission for com-admin
            $permissions= Permission::select('id')->where('weight','<=',2)->get();
            if(isset($permissions) && !empty($permissions))
            {
                foreach ($permissions as $permission) {
                    $role_permission= new PermissionRole();
                    $role_permission->role_id=$role_id;
                    $role_permission->permission_id= $permission->id;
                    $role_permission->status= 'active';
                    $role_permission->save();
                }
            }


            #print_r($input_role_user);exit;

            // Create default user role
            $input_user_role = [
                'title'=>$input['title'].' | Com. User',
                'slug'=>strtolower($company_name.'-user'),
                'status'=>'active',
                'company_id'=>$company_id,
                'type'=>'user',
                'created_by'=>1,
            ];
            $user_role= Role::create($input_user_role);

            // Give permission for user role
            $permissions= Permission::select('id')->where('weight',1)->get();
            if(isset($permissions) && !empty($permissions))
            {
                foreach ($permissions as $permission) {
                    $role_permission= new PermissionRole();
                    $role_permission->role_id=$user_role->id;
                    $role_permission->permission_id= $permission->id;
                    $role_permission->status= 'active';
                    $role_permission->save();
                }
            }
            $email=$user_id->email;

            Mail::send('admin::signup.email', array('token' =>$input_data['remember_token'],'user_id'=>$user_id->id),function($message) use ($email)
            {
                $message->from('test@edutechsolutionsbd.com', 'Account activation link');
                $message->to($email);
                $message->subject('Account activation link');
            });

            DB::commit();
            Session::flash('message', 'Successfully Completed Signup Process! Please check your email for account activation link ');
            #LogFileHelper::log_info('store_signip_info', 'Successfully add', $input_data);
        }catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('error', $e->getMessage());
            LogFileHelper::log_error('store_signup_info', $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route('get-user-login');
    }
    public function active_account($user_id,$token)
    {
        $user=User::findOrFail($user_id);
        if(!empty($user))
        {
            if($token==$user->remember_token)
            {
                $user->status='active';
                $user->remember_token='';
                $user->save();
                Session::flash('message','Your account is active. Please LogIn.');
                return redirect()->to('get-user-login');
            }elseif($user->status=='register'){
                $user->remember_token=str_random(30);
                $user->save();
                $email=$user->email;
                $remember_token=$user->remember_token;
                Mail::send('admin::signup.email', array('token' =>$remember_token,'user_id'=>$user_id),function($message) use ($email)
                {
                    $message->from('test@edutechsolutionsbd.com', 'Account activation link');
                    $message->to($email);
                    $message->subject('Account activation link');
                });
                Session::flash('message','We are again sent a activation link on your email. Please check your email.');
                return redirect()->to('get-user-login');
            }

        }else{
            Session::flash('error','Sorry,This user is not exist. Please Sign Up.');
            return redirect()->to('sign-up');
        }
    }
    public function forget_password_view()
    {
        //exit('exit');
        $data['pageTitle'] = 'Forget Password';
        return view('admin::forget_password._form',$data);
    }
    public function forget_password()
    {
        $email = Input::get('email');

        $user_exists = DB::table('user')->where('email', '=', $email)->exists();
        if($user_exists){

            $user = DB::table('user')->where('email', '=', $email)->first();
            #print_r($user);exit;
            $model = new UserResetPassword();
            $model->user_id = $user->id;
            $model->reset_password_token = str_random(30);
            $token = $model->reset_password_token;
            $model->reset_password_expire = date("Y-m-d h:i:s", (strtotime(date('Y-m-d h:i:s', time())) + (60 * 30)));
            $model->reset_password_time = date('Y-m-d h:i:s', time());
            $model->status = 2;
            if($model->save()) {

                try{
                    Mail::send('admin::forget_password.email_notification', array('link'=>$token,'user'=>$user),
                        function($message) use ($user)
                        {
                            $message->from('devdhaka405@gmail.com', 'User Password Set Notification');
                            //$message->from('tanintjt.1990@gmail.com', 'AFFIFACT');
                            $message->to($user->email);
                            $message->replyTo('devdhaka405@gmail.com','forgot password Request');
                            $message->subject('Forgot Password Reset Mail');
                        });

                    #print_r($user);exit;
                    Session::flash('message', 'Successfully sent email to reset password. Please check your email!');
                }catch (\Exception $e){

                    Session::flash('error', $e->getMessage());
                }
            }else{
                Session::flash('error', 'Does not Save!');
            }
        }else{
            Session::flash('error', 'The Specified Email address Is not Listed On Your Account. Please Try Again.');
        }
        return redirect()->back();
    }
    public function password_reset_confirm($reset_password_token){

        $user = UserResetPassword::where('reset_password_token','=',$reset_password_token)->first();
        $current_time = date('Y-m-d h:i:s', time());
        if(isset($user)) {
            $data = [
                isset($user->id) ? 'user_id': '' => isset($user->id) ? $user->id : '',
                'reset_password_expire' => isset($user) ? $user->reset_password_expire : '',
                'reset_password_time'=> isset($user) ? $user->reset_password_time : '',
                'status'=> isset($user) ? $user->status : '',
            ];
            if ($data['reset_password_expire'] > $current_time && $data['status'] == 2) {
                $id =  isset($user->id) ?$data['user_id']:'';
                return view('admin::forget_password.reset_password_form',['id'=>$id]);
            }
            if($data['reset_password_expire'] < $current_time){
                Session::flash('error', 'Time Expired.Please Try Again.');
                return redirect()->back();
            }
            if($data['status'] == 0) {
                Session::flash('error', 'You can Not Access To This link.Please Try Again.');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'Invalid Password Reset Link.Please Try Again.');
            return redirect()->route('get-user-login');
        }
        return redirect()->route('get-user-login');
    }

    public function save_new_password(Request $request)
    {

        $data = $request->all();
        $user_id = DB::table('user_reset_password')->where('id', '=', $data['id'])->first();

        $model = User::findOrFail($user_id->user_id);

        if($data['confirm_password']==$data['password']) {
            //update status and password
            date_default_timezone_set("Asia/Dacca");
            $user_update_data =[
                'password'=>Hash::make($data['password']),
                'last_visit'=>date('Y-m-d h:i:s', time()),
            ];
            DB::beginTransaction();
            try {
                if ($model->update($user_update_data)) {
                    DB::table('user_reset_password')->where('user_id', '=', $user_id->user_id)->update(array('status' => 0));
                }
                DB::commit();
                Session::flash('message', 'You have reset your password successfully. You may signin now.');
                LogFileHelper::log_info('save_new_password', 'successfully reset password',["New password for user_id".$user_id->user_id]);
                return redirect()->route('get-user-login');
            }catch(Exception $e){
                Session::flash('message', $e->getMessage());
                LogFileHelper::log_error('save_new_password', $e->getMessage(), ["New password for user_id".$user_id->user_id]);
            }
        }else{
            Session::flash('error', "Password and Confirm Password Does not match !");
        }
        return redirect()->back();
    }

    public function logout() {

        $user_act_model = new UserActivity();

        /* Transaction Start Here */
        DB::beginTransaction();
        try{
            $user_activity = [
                'action_name' => 'user-logout',
                'action_url' => 'user-logout',
                'action_details' => Auth::user()->username.' '. 'logged out',
                'action_table' => 'user',
                'date' => date('Y-m-d h:i:s', time()),
                'user_id' => Auth::user()->id,
            ];
            $user_act_model->create($user_activity);

            Auth::logout();

            DB::commit();
            Session::flash('message', 'You Are Now Logged Out.');
        }catch(\Exception $e){
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('error', $e->getMessage());
        }

        Session::flush(); //delete the session

        return redirect()->route('get-user-login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "User List";

        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin') {
            $model = User::with('relCompany')->where('status', '!=', 'cancel')->where('id', '!=', Session::get('user_id'))->orderBy('id', 'DESC')->paginate(30);
            $role =  [''=>'Select Role'] +  Role::lists('title','id')->all();
            $company=  [''=>'Select Company'] +  Company::lists('title','id')->all();
        }else{
            $model = User::where('status', '!=', 'cancel')->where('id', '!=', Session::get('user_id'))->where('company_id', Session::get('company_id'))->orderBy('id', 'DESC')->paginate(30);
            $role =  [''=>'Select Role'] +  Role::where('company_id', Session::get('company_id'))->lists('title','id')->all();

            $company=  [];
        }

//        $department_data =  [''=>'Select Department'] + Department::lists('title','id')->all();
        /*set 30days for expire-date to user*/
        $i=30;
        $add_days = +$i.' days';
        $days= date('Y/m/d H:i:s', strtotime($add_days, strtotime(date('Y/m/d H:i:s'))));

        return view('admin::user.index', ['model' => $model, 'pageTitle'=> $pageTitle,'role'=>$role,'days'=>$days,'company'=>$company]);
    }
    /*public function getRoutes(){
        \Artisan::call('route:list');
        return \Artisan::output();
    }*/


    public function search_user(){

        $pageTitle = 'User Informations';
        $model = new User();

        $role_id=Session::get('role_id');
        if($this->isGetRequest()){
            $company_id = Input::get('company_id');
            $username = Input::get('username');
            $status = Input::get('status');

            $model = $model->select('user.*');
            $model = $model->where('id', '!=', Session::get('user_id'));
            if(isset($username) && !empty($username)){
                $model = $model->where('user.username', 'LIKE', '%'.$username.'%');
            }
            if(isset($company_id) && !empty($company_id)){
                $model = $model->where('user.company_id', '=', $company_id);
            }
            if(isset($status) && !empty($status)){
                $model = $model->where('user.status', '=', $status);
            }

            if($role_id != 'sadmin' && $role_id !='admin') {
                $model = $model->where('user.company_id', '=', Session::get('company_id'));
            }
            $model = $model->paginate(30);

        }else{
            $model = $model->with('relBranch','relRoleInfo')->where('status','!=','cancel')->orderBy('id', 'DESC')->paginate(30);
        }

        $i=30;
        $add_days = +$i.' days';
        $days= date('Y/m/d H:i:s', strtotime($add_days, strtotime(date('Y/m/d H:i:s'))));

        $company=  [''=>'Select Company'] +  Company::lists('title','id')->all();

        if($role_id== 'sadmin' || $role_id=='admin') {
            $role =  [''=>'Select Role'] +  Role::lists('title','id')->all();
        }else{
            $role =  [''=>'Select Role'] +  Role::where('company_id', Session::get('company_id'))->lists('title','id')->all();

        }
        #$role =  [''=>'Select Role'] +  Role::lists('title','id')->all();


        return view('admin::user.index',['pageTitle'=>$pageTitle,'model'=>$model,'role'=>$role,'days'=>$days,'company'=>$company]);
    }
    public function add_new_user(){

        $pageTitle = "Add User";
        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin') {
            $role =  Role::whereNotIn('slug', ['facebook','twitter','google_plus'])->select('title','id','type')->get();

            $company=  [''=>'Select Company'] +  Company::lists('title','id')->all();
        }else{
            $role =  Role::select('title','id','type')->where('company_id', Session::get('company_id'))->get();

            $company=  [];
        }
        $social_role= Role::whereIn('slug', ['facebook','twitter','google_plus'])->select('slug','id')->get();
//        $department_data =  [''=>'Select Department'] + Department::lists('title','id')->all();
        /*set 30days for expire-date to user*/
        $i=30;
        $add_days = +$i.' days';
        $days= date('Y/m/d', strtotime($add_days, strtotime(date('Y/m/d H:i:s'))));
        return view('admin::user.create', ['pageTitle'=> $pageTitle,'role'=>$role,'days'=>$days,'company'=>$company,'social_role'=>$social_role]);
    }
    public function add_user(Requests\UserRequest $request){

        $input = $request->all();
//        dd($input);
        $input['expire_date']=date('Y-m-d',strtotime($input['expire_date']));
        #print_r($input);exit;
        date_default_timezone_set("Asia/Dacca");
        $now = new DateTime();
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            $input_data = [
                'username'=>$input['username'],
                'email'=>$input['email'],
                'password'=>Hash::make($input['password']),
                'csrf_token'=> str_random(30),
                'ip_address'=> getHostByName(getHostName()),
                'company_id'=> Session::get('company_id'),
                'role_id'=> $input['role_id'],
                'expire_date'=> $input['expire_date'],
                'status'=> $input['status'],
            ];
            #print_r($input_data);exit;

            if($user = User::create($input_data)){
                $role_user = [
                    'user_id'=>$user['id'],
                    'role_id'=>$input['role_id'],
                    'status'=>'active',
                ];
                RoleUser::create($role_user);
                if(isset($input['social_media'])){
                    foreach ($input['social_media'] as $id=>$value) {
                        $role_user=[
                            'user_id'=>$user['id'],
                            'role_id'=>$value,
                            'status'=>'active',
                        ];
                        RoleUser::create($role_user);
                    }
                }
            }

            $email=$user->email;
            $company= Company::findOrFail( Session::get('company_id'));

            Mail::send('admin::user.email', ['company_name'=>$company->title]+$input,function($message) use ($email)
            {
                $message->from('test@edutechsolutionsbd.com', 'Account Information');
                $message->to($email);
                $message->subject('Account activation link');
            });

            DB::commit();
            Session::flash('message', 'Successfully added!');
            LogFileHelper::log_info('user-add', 'Successfully added!', ['Username: '.$input_data['username']]);
        } catch (\Exception $e) {
            DB::rollback();
            //If there are any exceptions, rollback the transaction`
            Session::flash('danger', $e->getMessage());
            LogFileHelper::log_error('user-add', $e->getMessage(), ['Username: '.$input['username']]);
            return redirect()->back();
        }

        return redirect()->to('user-list');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_user($id)
    {
        $pageTitle = 'User Informations';
        $data = User::with('relRoleInfo')->where('id',$id)->first();

        return view('admin::user.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_user($id)
    {
        $pageTitle = 'Edit User Information';

        $data = User::findOrFail($id);

        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin') {
            $role =  Role::whereNotIn('slug', ['facebook','twitter','google_plus'])->select('title','id','type')->get();
        }else{
            $role =  Role::select('title','id','type')->where('company_id', Session::get('company_id'))->get();
        }
        $social_role= Role::whereIn('slug', ['facebook','twitter','google_plus'])->select('slug','id')->get();
        $activeSocialRole= RoleUser::select('role_id')->where('user_id',$id)->get();

        foreach ($social_role as $id=>$sr) {
            foreach ($activeSocialRole as $asr) {
                if($sr->id==$asr->role_id)
                {
                    $social_role[$id]->active=1;
                }
            }
        }

        $selected_role_type= Role::findOrFail($data->role_id);
        $selected_role_type= $selected_role_type->type;

//        $role =  [''=>'Select Role'] +  Role::lists('title','id')->all();

        return view('admin::user.update', ['pageTitle'=>$pageTitle,'data' => $data,'role'=>$role,'social_role'=>$social_role,'selected_role_type'=>$selected_role_type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user(Request $request, $id)
    {
        $input = Input::all();
        $email_check= User::where('email',$input['email'])->first();
        if($email_check->id==$id) {
            $input['expire_date'] = date('Y-m-d', strtotime($input['expire_date']));
            $model1 = User::findOrFail($id);
            if ($input['re_password'] != Null) {
                $password = Hash::make($input['re_password']);
            } else {
                $password = $input['password'];
            }

            $now = new DateTime();

            $input_data = [
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => $password,
                'csrf_token' => str_random(30),
                'ip_address' => getHostByName(getHostName()),
                'last_visit' => $now,
                'role_id'=> $input['role_id'],
                'expire_date' => $input['expire_date'],
                'status' => $input['status'],
            ];
            DB::beginTransaction();
            try {
                $model1->update($input_data);
                // update role user
                $role_user=RoleUser::where('user_id',$model1->id)->first();
                $role_user->role_id=$input['role_id'];
                $role_user->save();

                $checkRole=Role::findOrFail($input['role_id']);
                if($checkRole->type=='user') {

                    if (isset($input['social_media'])) {
                        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                        $activeRole=RoleUser::where('user_id', $model1->id)->whereNotIn('role_id', [$role_user->role_id])->delete();


                        foreach ($input['social_media'] as $id => $value) {

                            $role_user = [
                                'user_id' => $model1->id,
                                'role_id' => $value,
                                'status' => 'active',
                            ];
                            RoleUser::create($role_user);
                        }
                    }
                }else{
                    DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                    RoleUser::where('user_id', $model1->id)->whereNotIn('role_id', [$role_user->role_id])->delete();
                }

                DB::commit();
                Session::flash('message', "Successfully Updated");
                #LogFileHelper::log_info('update-user', 'Successfully Updated!', ['Username:'.$input['username']]);

            } catch (Exception $e) {
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', $e->getMessage());
                #LogFileHelper::log_error('update-user', 'error!'.$e->getMessage(), ['Username:'.$input['username']]);
            }
        }else{
            Session::flash('error', 'Email already exist');
            return redirect()->back();
        }
        //role-user update if exists...
        #print_r($model1->role_id);exit;

        return redirect()->to('user-list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_user($id)
    {

        $model = User::where('id',$id)->first();

        DB::beginTransaction();
        try {
            if($model->status =='active'){
                $model->status = 'cancel';
                $model->last_visit = Null;
            }
            $model->save();

            DB::commit();
            Session::flash('message', "Successfully Deleted.");
            LogFileHelper::log_info('destroy-user', 'Successfully Deleted!change status to cancel',['User id:'.$model->id]);

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
            LogFileHelper::log_error('user-destroy', $e->getMessage(), ['User id:'.$model->id]);
        }
        return redirect()->route('user-list');
    }

    public function create_user_info()
    {
        if(Auth::check())
        {
            $pageTitle = 'User Profile';
            $user_id = Auth::user()->id;
            $data = UserProfile::with('relUser')->where('user_id',$user_id)->first();
            $profile_data = UserProfile::where('user_id',$user_id)->first();
            $user_image = UserImage::where('user_id',$user_id)->first();
            $user = User::where('id',$user_id)->first();

            return view('admin::user_info.index',['data'=>$data,'user_id'=>$user_id,'profile_data'=>$profile_data,'user_image'=>$user_image,'user'=>$user,'pageTitle'=>$pageTitle]);
        }
    }
    public function user_info($value){
        $user_id = Auth::user()->id;

        /*if($this->isPostRequest()){*/
        try{
            if($value == 'profile'){
                $data = UserProfile::with('relUser')->where('user_id',$user_id)->first();
                return Response::json(view('admin::user_info.profile.ajax_profile_data', ['data' => $data])->render());
            }
            if($value == 'meta'){
                $data = UserMeta::with('relUser')->where('user_id',$user_id)->first();
                return Response::json(view('admin::user_info.meta_data.ajax_meta_data', ['data' => $data])->render());
            }
            if($value == 'acc-settings'){
                $profile_data = UserProfile::with('relUser')->where('user_id',$user_id)->first();
                $user_data = User::with('relRoleInfo')->where('id',$user_id)->first();
                return Response::json(view('admin::user_info.account_settings._ajax_data', ['user_data' => $user_data,'profile_data'=>$profile_data])->render());
            }

        }catch(\Exception $e){
            return Response::json($e);
        }

        /*}else{
              return Response::json('only for ajax request!');
          }*/

    }

    public function inactive_user_dashboard(){
        return view('admin::user_info.inactive_user_dashboard');
    }

    public function create_profile()
    {
        $pageTitle = 'Add Profile';
        $user_id = Auth::user()->id;
        $profile_data = UserProfile::where('user_id',$user_id)->first();
        $user_image = UserImage::where('user_id',$user_id)->first();
        $user = User::where('id',$user_id)->first();

        return view('admin::user_info.profile.create',['user_id'=>$user_id,'profile_data'=>$profile_data,'user_image'=>$user_image,'user'=>$user,'pageTitle'=>$pageTitle]);

    }


    public function store_user_profile(Requests\UserProfileRequest $request){

        $input = $request->all();
        $input['date_of_birth']=date('Y-m-d',strtotime($input['date_of_birth']));

        $image_model = new UserImage();
        $profile_model = new UserProfile();

#print_r($image);exit;

        DB::beginTransaction();
        try {
            $profile_model->create($input);
            DB::commit();
            Session::flash('message', "Successfully Added");
            #LogFileHelper::log_info('store_user_profile', 'Successfully added', ['User profile firstname:'.$input['first_name']]);
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', 'Profile Information Do not Added');
            #LogFileHelper::log_error('store-user-profile', $e->getMessage(),  ['User profile firstname:'.$input['first_name']]);
        }

        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';

            //print_r(base_path('public').'/'.$uploadfolder);exit;//public_html

            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }/*else{
                chmod(base_path('public').'/'.$uploadfolder, 0777);
            }*/

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }/*else{
                chmod(base_path('public').'/'.$uploadfolder, 0777);
            }*/

            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);

            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                $image_model->create($input);
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('store-user-profile', 'Successfully added', ['User profile image:'.$input['image']] );
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', " Profile Image Do Not added");
                #LogFileHelper::log_error('store-user-profile', $e->getMessage(), ['User profile image:'.$input['image']] );
            }
        }
        return redirect()->to('user-profile');
    }

    public function edit_user_profile($id){

        $pageTitle = 'Edit User Profile Information';

        $data = UserProfile::findOrFail($id);
        $user_id = Auth::user()->id;

        $user_image = UserImage::where('user_id',$user_id)->first();
        #$user_image_id = ($user_image->id)?$user_image->id:'';

        return view('admin::user_info.profile.update', ['pageTitle'=>$pageTitle,'data' => $data,'user_id'=>$user_id,'user_image'=>$user_image]);
    }

    public function update_user_profile(Requests\UserProfileRequest $request,$id){

        $input = $request->all();
        $input['date_of_birth']=date('Y-m-d',strtotime($input['date_of_birth']));
        $user_id = Auth::user()->id;

        $profile_model = UserProfile::findOrFail($id);

        DB::beginTransaction();
        try {
            $profile_model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Added");
            #LogFileHelper::log_info('update-user-profile', 'successfully updated', ['User profile firstname:'.$input['first_name']]);
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('error', 'Profile Information Do not Added');
            #LogFileHelper::log_error('update-user-profile', $e->getMessage(), ['User profile firstname:'.$input['first_name']]);
        }

        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';

            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }

            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);
            #print_r($file_name);exit;
            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
//                $image_model = $user_image_id ? UserImage::findOrFail($user_image_id):new UserImage();
                $user_image_exists = UserImage::where('user_id',$user_id)->exists();
                if($user_image_exists){
                    $user_image = UserImage::where('user_id',$user_id)->first();
                    $image_model = UserImage::findOrFail($user_image['id']);
                }else{
                    $image_model = new UserImage();
                }

                $image_model->fill($input)->save();
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('update-user-profile', 'Successfully added',  ['User profile image:'.$input['image']]);
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', " Profile Image Do Not added");
                #LogFileHelper::log_error('update-user-profile', $e->getMessage(),  ['User profile image:'.$input['image']]);
            }
        }
        return redirect()->route('user-profile');
    }

    public function store_profile_image(Request $request){

        $input = $request->all();



        $image_model = new UserImage();
        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';


            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }



            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);

            //print_r($file_name);exit;

            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                $image_model->create($input);
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('store-profile-image', 'successfully added', ['User profile image:'.$input['image']]);
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', "Profile Image Do Not added");
                #LogFileHelper::log_error('store-profile-image', $e->getMessage(),  ['User profile image:'.$input['image']]);
            }
        }
        return redirect()->back();
    }

    public function edit_profile_image($user_image_id){

        $pageTitle = 'Edit User Profile Picture';
        $model = UserImage::findOrFail($user_image_id);
        return view('admin::user_info.profile_image.update_image', ['pageTitle'=>$pageTitle,'model'=>$model,'user_image_id'=>$user_image_id]);
    }

    public function update_profile_image(Request $request,$user_image_id){

        $input = $request->all();

        $image_model = UserImage::findOrFail($user_image_id);

        $image = Input::file('image');

        if(count($image)>0){
            $file_type_required = 'png,gif,jpeg,jpg';
            $destinationPath = 'uploads/user_image/';

            $uploadfolder = 'uploads/';

            if ( !file_exists($uploadfolder) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($uploadfolder, 0777);
            }

            if ( !file_exists($destinationPath) ) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir ($destinationPath, 0777);
            }

            $file_name = UserController::image_upload($image,$file_type_required,$destinationPath);
            if($file_name != '') {
//                unlink($model->image);
//                unlink($model->thumbnail);
                $input['image'] = $file_name[0];
                $input['thumbnail'] = $file_name[1];
            }
            else{
                Session::flash('error', 'Some thing error in image file type! Please Try again');
                return redirect()->back();
            }
            DB::beginTransaction();
            try {
                $image_model->update($input);
                DB::commit();
                Session::flash('message', "Successfully added");
                #LogFileHelper::log_info('update-profile-image', 'successfully update',  ['User profile image:'.$input['image']]);
            }
            catch ( Exception $e ){
                //If there are any exceptions, rollback the transaction
                DB::rollback();
                Session::flash('error', " Profile Image Do Not added");
                #LogFileHelper::log_error('update-profile-image', $e->getMessage(), ['User profile image:'.$input['image']]);
            }
        }
        return redirect()->route('user-profile');
    }

    public function store_meta_data(Request $request){

        $input = $request->all();


        $image = Input::file('signature');

        if(count($image)>0) {

            $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');
            $validator = Validator::make(array('file' => $image), $rules);
            if ($validator->passes()) {
                // Files destination
                $destinationPath = 'uploads/user_image/';

                // Create folders if they don't exist
                if ( !file_exists($destinationPath) ) {
                    $oldmask = umask(0);  // helpful when used in linux server
                    mkdir ($destinationPath, 0777);
                }

                $file_original_name = $image->getClientOriginalName();
                $file_name = rand(11111, 99999) . $file_original_name;
                $upload_success = $image->move($destinationPath, $file_name);
                $input['signature'] = 'uploads/user_image/' . $file_name;
            }
        }
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            UserMeta::create($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');
            #LogFileHelper::log_info('store-meta-data', 'Successfully added', ['User metadata signature:'.$input['signature']]);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            #LogFileHelper::log_error('store-meta-data', $e->getMessage(),['User metadata signature:'.$input['signature']]);
        }
        return redirect()->route('user-profile');
    }

    public function edit_meta_data($id){

        $pageTitle = 'Edit Biographical Information';

        $data = UserMeta::findOrFail($id);
        $user_id = Auth::user()->id;

        return view('admin::user_info.meta_data.update', ['pageTitle'=>$pageTitle,'data' => $data,'user_id'=>$user_id]);
    }

    public function update_meta_data(Request $request,$id){

        $input = $request->all();

        $model= UserMeta::findOrFail($id);

        $image = Input::file('signature');

        if(count($image)>0) {

            $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc,jpg,docx,pptx,ppt,pub');
            $validator = Validator::make(array('file' => $image), $rules);
            if ($validator->passes()) {
                // Files destination
                $destinationPath = 'uploads/user_image/';

                // Create folders if they don't exist
                if ( !file_exists($destinationPath) ) {
                    $oldmask = umask(0);  // helpful when used in linux server
                    mkdir ($destinationPath, 0777);
                }

                $file_original_name = $image->getClientOriginalName();
                $file_name = rand(11111, 99999) . $file_original_name;
                $upload_success = $image->move($destinationPath, $file_name);
                $input['signature'] = 'uploads/user_image/' . $file_name;
            }
        }
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', 'Successfully Updated!');
            #LogFileHelper::log_info('update-meat-data', 'Successfully updated',['User metadata signature:'.$input['signature']]);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            #LogFileHelper::log_error('update-meta-data', $e->getMessage(), ['User metadata signature:'.$input['signature']]);
        }
        return redirect()->back();
    }

    public function change_user_password_view()
    {
        return view('admin.change_password._form');
    }

    public function update_password()
    {
        if(Auth::check())
        {
            $input = Input::all();

            if($input['confirm_password']==$input['password']) {
                $hash_check = Hash::check($input['pass'], User::findOrNew(Auth::user()->id)->password);

                if ($hash_check > 0) {
                    $model = User::findOrNew(Auth::user()->id);
                    $model->password = Hash::make($input['password']);
                    /* Transaction Start Here */
                    DB::beginTransaction();
                    try {
                        $model->save();

                        DB::commit();
                        Session::flash('message', "Successfully Updated Your Password");
                        #LogFileHelper::log_info('update-user-password', 'Successfully update password', ['User id: '.$model->id]);

                    } catch (Exception $e) {
                        //If there are any exceptions, rollback the transaction
                        DB::rollback();
                        Session::flash('error',$e->getMessage());
                        #LogFileHelper::log_error('update-user-password', $e->getMessage(), ['User id: '.$model->id]);
                    }
                } else {
                    Session::flash('error', "Your old password is not correct !");
                }
            }
            else{
                Session::flash('error', "Password and Confirm Password Does not match !");
            }
        }
        else
        {
            Session::flash('error', "Please Login !" );
        }
        return redirect()->back();
    }

    public function image_upload($image,$file_type_required,$destinationPath){

        if ($image != '') {
            $img_name = ($_FILES['image']['name']);
            $random_number = rand(111, 999);

            $thumb_name = 'thumb_50x50_'.$random_number.'_'.$img_name;

            $newWidth=200;
            $targetFile=$destinationPath.$thumb_name;
            $originalFile=$image;

            $resizedImages 	= ImageResize::resize($newWidth, $targetFile,$originalFile);
            //print_r($resizedImages);exit;
            $thumb_image_destination=$destinationPath;
            $thumb_image_name=$thumb_name;

            //$rules = array('image' => 'required|mimes:png,jpeg,jpg');
            $rules = array('image' => 'required|mimes:'.$file_type_required);
            $validator = Validator::make(array('image' => $image), $rules);
            if ($validator->passes()) {
                // Files destination
                //$destinationPath = 'uploads/slider_image/';
                // Create folders if they don't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $image_original_name = $image->getClientOriginalName();
                $image_name = rand(11111, 99999) . $image_original_name;




                $upload_success = $image->move($destinationPath, $image_name);

                $file=array($destinationPath . $image_name, $thumb_image_destination.$thumb_image_name);

                if ($upload_success) {
                    return $file_name = $file;
                }
                else{
                    return $file_name = '';
                }
            }
            else{
                return $file_name = '';
            }
        }
    }

}
