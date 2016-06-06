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
use App\Helpers\FacebookHelper;
use App\Helpers\TwitterHelper;
use App\Http\Controllers\Controller;
use App\PostSocialMedia;
use App\Schedule;
use App\SmType;
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
        $data['all_social_media']=SmType::select('id','type')->get();
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
        DB::beginTransaction();
        try{
            $company_id=Session::get('companyId');
            if(isset($company_id) && $company_id!=0) {
                $input = $request->except('_token');
                $custom_post = new CustomPost();
                $custom_post->company_id = $company_id;
                $custom_post->text = $input['text'];
                $custom_post->status = 'new';
                $custom_post->save();
                if(isset($input['social_media']) && !empty($input['social_media']))
                {
                    foreach ($input['social_media'] as $sm) {
                        $post_social_media= new PostSocialMedia();
                        $post_social_media->custom_post_id=$custom_post->id;
                        $post_social_media->social_media_id=$sm;
                        $post_social_media->status='new';
                        $post_social_media->save();
                    }
                }
                Session::flash('message', 'Post has been stored successfully');
                DB::commit();
            }else{
                Session::flash('error', 'Sorry,You are not set your company yet !!');
            }
        }catch (Exception $e)
        {
            DB::rollback();
            Session::flash('error',$e->getMessage());
        }
        return redirect()->back();
    }
    public function edit($id)
    {
        $data['pageTitle']='Edit post';
        $data['all_social_media']=SmType::select('id','type')->get();
        $data['post']=CustomPost::findOrFail($id);
        $active_social_media=PostSocialMedia::select('social_media_id')->where('custom_post_id',$id)->get();
        $social_media=[];
        foreach ($active_social_media as $asm) {
            $social_media[]=$asm->social_media_id;
        }
        $data['post']->social_media=$social_media;
        return view('www::custom_post.edit',$data);
    }
    public function update(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $custom_post = CustomPost::findOrFail($id);
            $custom_post->text = $input['text'];
            $custom_post->save();
            if (isset($input['social_media']) && !empty($input['social_media'])) {
                PostSocialMedia::where('custom_post_id',$id)->delete();
                foreach ($input['social_media'] as $sm) {
                    $post_social_media = new PostSocialMedia();
                    $post_social_media->custom_post_id = $custom_post->id;
                    $post_social_media->social_media_id = $sm;
                    $post_social_media->status = 'new';
                    $post_social_media->save();
                }
            }
            Session::flash('message','Post has been updated successfully');
            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            Session::flash('error',$e->getMessage());
        }
        return redirect()->back();
    }
    public function publish($id)
    {
        $socialMediaToPost= PostSocialMedia::select('social_media_id')->where('custom_post_id',$id)->where('status','new')->get();
        if(isset($socialMediaToPost)) {
            $i=0;
            $error='';
            foreach ($socialMediaToPost as $smtp) {
                if ($smtp->social_media_id == 1) {
                    $i++;
                } elseif ($smtp->social_media_id == 2) {
                    $status = FacebookHelper::publish($id);
//                    $status='Not ........';
                    if(isset($status) && $status=='success')
                    {
                        $i++;
                    }else{
                        $error .='Facebook => '.$status;
                    }
                } elseif ($smtp->social_media_id == 3) {
                    $status = TwitterHelper::publish($id);
//                    $status='success';
                    if(isset($status) && $status=='success')
                    {
                        $i++;
                    }else{
                        $error.='<br><b>Twitter =></b>'.$status;
                    }
                }
            }
            if(count($socialMediaToPost) == $i)
            {
                $custom_post=CustomPost::findOrFail($id);
                $custom_post->status= 'sent';
                $custom_post->save();
                Session::flash('message', 'Post has been successfully sent to social media.');
            }else{
                Session::flash('danger', $error);
            }
        }else{
            Session::flash('error', 'Sorry,No social media selected to post data !!');
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