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
    public function feeds(Request $request)
    {
        if($request->is('*/instagram'))
        {
            $sm_type_id=4;
        }else{
            return back();
        }
        if(session('role_id')=='admin' || session('role_id')=='sadmin') {
            $data['posts']=Post::where('sm_type_id', $sm_type_id)->paginate(20);
        }else{
            $data['posts']=Post::where('sm_type_id',$sm_type_id)->where('company_id',session('company_id'))->paginate(20);
        }
        $data['pageTitle']='Instagram Newsfeed';

        return view('www::feeds.index',$data);
    }
    public function details(Request $request,$post_id)
    {
        if($request->is('*/instagram/*'))
        {
            $sm_type_id=4;
        }else{
            return back();
        }

        if(session('role_id')=='admin' || session('role_id')=='sadmin') {
            $data['post'] = Post::where('id', $post_id)->where('sm_type_id', $sm_type_id)->with(['relComment', 'relPostImage'])->first();
        }else{
            $data['post'] = Post::where('id', $post_id)->where('sm_type_id', $sm_type_id)->where('company_id', session('company_id'))->with(['relComment', 'relPostImage'])->first();
        }
        if($data['post'] == null) return back();
        $data['pageTitle']='Post Details';
//        dd($data['post']);
        return view('www::feeds.details',$data);

    }
}