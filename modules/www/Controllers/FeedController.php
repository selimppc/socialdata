<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/11/16
 * Time: 2:04 PM
 */

namespace Modules\Www\Controllers;


use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        dd($request->url());
    }
    public function instagram()
    {
        $data['pageTitle']='Instagram Newsfeed';
        $data['posts']=$this->_feeds(4);
        return view('www::feeds.index',$data);
    }
    private function _feeds($sm_type_id)
    {
        return Post::where('sm_type_id',$sm_type_id)->where('company_id',session('company_id'))->paginate(20);
    }
    public function details($post_id)
    {
        $data['post']=Post::where('id',$post_id)->where('company_id',session('company_id'))->with(['relComment','relPostImage'])->first();
        // if post is null then redirect back
        if($data['post'] == null) return back();
        $data['pageTitle']='Post Details';
//        dd($data['post']);
        return view('www::feeds.details',$data);
    }
}