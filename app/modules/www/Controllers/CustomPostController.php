<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/31/16
 * Time: 10:28 AM
 */

namespace App\Modules\Www\Controllers;

use App\CustomPost;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CustomPostController extends Controller
{
    public function index()
    {
        $company_id=Session::get('companyId');
        $data['pageTitle']='Custom Posts';
        $data['posts']=CustomPost::where('company_id',$company_id)->get();
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
            $custom_post->status = 'active';
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
}