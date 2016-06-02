<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/2/16
 * Time: 9:09 AM
 */

namespace App\Modules\Www\Controllers;

use App\Http\Controllers\Controller;
use App\Role;
use App\RoleUser;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserRegistrationController extends Controller
{
    public function create()
    {
        $data['role']=Role::lists('title','id');
        return view('www::request._form',$data);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        $user =  Auth::user()->id;
        $email = $request->email;
        $type = $request->type;
        $user_data = User::where('email','=',$email)->first();
        if($user_data){
            Session::flash('flash_message_error','This User Already Exist.');
        }else{
            if($email){
                $e=explode('@',$email);
                $input_data = [
                    'email'=>$email,
                    'username'=>$e[0],
                    'remember_token'=> str_random(30),
                    'status'=> 'invited',
                    'company_id'=> Session::get('companyId'),
                    'expire_date'=> $request->expire_date,
                    'role_id'=> $type
                ];
                $model =  new User();
                $user=$model->create($input_data);
                if($user) {
                    try{
                        $role_user= new RoleUser();
                        $role_user->role_id=$type;
                        $role_user->user_id=$user->id;
                        $role_user->save();

                        Mail::send('www::request.mail_message', array('link' =>$input_data['remember_token'],'type'=>$type),function($message) use ($email)
                            {
                                $message->from('test@edutechsolutionsbd.com', 'User Signup Request');
                                $message->to($email);
//                                $message->cc('tanvirjahan.tanin@gmail.com', 'Tanin');
//                                $message->replyTo('tanintjt.1990@gmail.com','User Signup Request');
                                $message->subject('MemberShip Request');
                            });
                        DB::commit();
                        Session::flash('flash_message', " Successfully Send Email For MemberShip Request .");
                    }catch(\Exception $e){
                        DB::rollback();
                        Session::flash('danger', "Invalid Request! Your message do not send .Please try again.");
                    }
                }

            }else{
                Session::flash('danger', 'The Specified Email address Is not Listed On Your Account. Please Try Again.');
            }
        }
        return redirect()->back();
    }
    public function user_confirm($remember_token)
    {
//        $user = User::first();
        $user = User::where('remember_token','=',$remember_token)->first();
//        return view('www::request.index', ['user'=>$user]);
        if(!$user){
            Session::flash('flash_message_error', 'Invalid Confirmation Link.Please Try Again.');
        }
        else{
            return view('www::request.index', ['user'=>$user]);
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $model = User::findOrFail($request->id);
            $model->password=Hash::make($input['password']);
            $model->save();

            $profile= new UserProfile();
            $profile->user_id=$input['id'];
            $profile->first_name=$input['first_name'];
            $profile->last_name=$input['last_name'];
            $profile->address=$input['address'];
            $profile->telephone_number=$input['telephone_number'];
            $profile->save();
                try{
                    Mail::send('www::request.activate', array('link' =>$model['remember_token']),

                        function($message) use($input)
                        {
                            $message->from('test@edutechsolutionsbd.com', 'Login Activation Request');
                            $message->to($input['email']);
//                            $message->cc('tanvirjahan.tanin@gmail.com', 'Tanin');
//                            $message->replyTo('tanintjt.1990@gmail.com','Login Activation Request');
                            $message->subject('Login Activation');
                        });
                }catch(\Exception $e){
                    Session::flash('danger', "Invalid Request! Your message do not send .Please try again.");
                }
            DB::commit();
            Session::flash('flash_message', "Successfully Completed Registration Process.Please Check Your Email For Login Activation Link .");
        }
        catch ( \Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('flash_message_error', 'Invalid Request!');
        }
        //return view('user.login.activation_msg');
        return redirect()->back();
    }

    public function user_activation($remember_token)
    {
        $model = User::where('remember_token', $remember_token)->update(['status' => 'active']);

        if(!$model){
            Session::flash('flash_message_error', 'Invalid Confirmation Link.Please Try Again.');
        }
        else{
            Session::flash('flash_message', 'You have been activated successfully for login.');
            return redirect()->route('get-user-login');
        }
        return redirect()->back();
    }



}