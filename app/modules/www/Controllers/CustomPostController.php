<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/31/16
 * Time: 10:28 AM
 */

namespace App\Modules\Www\Controllers;

use App\CompanySocialAccount;
use App\CustomPost;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\SMConfigController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Mockery\CountValidator\Exception;


class CustomPostController extends Controller
{
    public function index()
    {
        $company_id=Session::get('companyId');
        $data['pageTitle']='Custom Posts';
        $data['posts']=CustomPost::with(['relSchedule'])->where('company_id',$company_id)->get();
        return view('www::custom_post.index',$data);
    }
    public function create()
    {
        $data['pageTitle']='Add new post';
        return view('www::custom_post.create',$data);
    }
    public function store(Request $request)
    {
        $company_id=Session::get('companyId');
        if(isset($company_id) && $company_id!=0) {
            $input = $request->except('_token');
            $custom_post = new CustomPost();
            $custom_post->company_id = $company_id;
            $custom_post->text = $input['text'];
            $custom_post->status = 'new';
            $custom_post->save();
            Session::flash('message', 'Post has been stored successfully');
        }else{
            Session::flash('error', 'Sorry,You are not set your company yet !!');
        }
        return redirect()->back();
    }
    public function edit($id)
    {
        $data['pageTitle']='Edit post';
        $data['post']=CustomPost::findOrFail($id);
        return view('www::custom_post.edit',$data);
    }
    public function update(Request $request,$id)
    {
        $input=$request->all();
        $custom_post= CustomPost::findOrFail($id);
        $custom_post->text=$input['text'];
        $custom_post->save();
        Session::flash('message','Post has been updated successfully');
        return redirect()->back();
    }
    public function publish_fb($id)
    {
        $config= SMConfigController::getFbConfig();
        $fb_account= CompanySocialAccount::where('company_id',Session::get('companyId'))->where('sm_type_id',2)->first();
        $fb= new Facebook($config);
        $fb->setDefaultAccessToken($fb_account->access_token);
        $pages=$fb->get('/me/accounts');
        $pages=$pages->getGraphEdge()->asArray();
        $page_access_token= null;
        $page_id= null;
        foreach ($pages as $page) {
            if($page['name']==$fb_account->page_id){
                $page_access_token=$page['access_token'];
                $page_id=$page['id'];
            }
        }
        if($page_access_token!=null && $page_access_token!=null)
        {
            try{
                $custom_post=CustomPost::findOrFail($id);
                $post=$fb->post('/'.$page_id.'/feed',['message'=>$custom_post->text],$page_access_token);
                $post=$post->getGraphNode()->asArray();
                if(isset($post['id']))
                {
                    $custom_post=CustomPost::findOrFail($id);
                    $custom_post->postId=$post['id'];
                    $custom_post->status='sent';
                    $custom_post->save();
                    Session::flash('message','Post has been successfully sent to social media.');
                }
            }catch (Exception $e)
            {
                Session::flash('error',$e->getMessage());
            }
        }else{
            Session::flash('error','Sorry,Something is wrong !!');
        }
        return redirect()->back();
    }
    public function create_schedule($id)
    {
        $data['pageTitle']='Create Schedule';
        $data['post_id']=$id;
        return view('www::custom_post.create_schedule',$data);
    }
    public function store_schedule(Request $request,$id)
    {
        $input=$request->all();
        $time=$input['date'].' '.$input['time'];
        DB::beginTransaction();
        try {
            $schedule = new Schedule();
            $schedule->time = $time;
            $schedule->custom_post_id = $id;
            $schedule->save();

            $custom_post= CustomPost::findOrFail($id);
            $custom_post->status='processing';
            $custom_post->save();
            DB::commit();
            Session::flash('message','Schedule has been create successfully');
        }catch (Exception $e){
            DB::rollBack();
            Sessioin::flash('error',$e->getMessage());
        }
        return redirect()->back();
    }
    public function show_schedule($schedule_id)
    {
        $data['pageTitle']='Show Schedule';
        $schedule=Schedule::findOrFail($schedule_id);
        $scd=explode(' ',$schedule->time);
        $schedule->time=$scd[1];
        $schedule->date=$scd[0];
        $data['schedule']=$schedule;
        return view('www::custom_post.show_schedule',$data);

    }
    public function edit_schedule($schedule_id)
    {
        $data['pageTitle']='Edit Schedule';
        $schedule=Schedule::findOrFail($schedule_id);
        $scd=explode(' ',$schedule->time);
        $schedule->time=$scd[1];
        $schedule->date=$scd[0];
        $data['schedule']=$schedule;
        return view('www::custom_post.edit_schedule',$data);

    }
    public function update_schedule(Request $request,$schedule_id)
    {
        $input=$request->all();
        $time=$input['date'].' '.$input['time'];
        DB::beginTransaction();
        try {
            $schedule = Schedule::findOrFail($schedule_id);
            $schedule->time = $time;
            $schedule->save();
            DB::commit();
            Session::flash('message','Schedule has been updated successfully');
        }catch (Exception $e){
            DB::rollBack();
            Sessioin::flash('error',$e->getMessage());
        }
        return redirect()->back();
    }
}