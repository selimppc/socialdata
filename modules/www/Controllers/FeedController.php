<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/11/16
 * Time: 2:04 PM
 */

namespace Modules\Www\Controllers;


use App\Helpers\FacebookHelper;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeedController extends Controller
{
    protected $sm_type;
    protected $sm_type_id;
    public function __construct(Request $request)
    {
        if($request->is('*/googleplus'))
        {
            $this->sm_type_id=1;
            $this->sm_type='googleplus';
        }elseif($request->is('*/facebook'))
        {
            $this->sm_type_id=2;
            $this->sm_type='facebook';
        }elseif($request->is('*/twitter'))
        {
            $this->sm_type_id=3;
            $this->sm_type='twitter';
        }elseif($request->is('*/instagram'))
        {
            $this->sm_type_id=4;
            $this->sm_type='instagram';
        }elseif($request->is('*/googleplus/*'))
        {
            $this->sm_type_id=1;
            $this->sm_type='googleplus';
        }elseif($request->is('*/facebook/*'))
        {
            $this->sm_type_id=2;
            $this->sm_type='facebook';
        }elseif($request->is('*/twitter/*'))
        {
            $this->sm_type_id=3;
            $this->sm_type='twitter';
        }elseif($request->is('*/instagram/*'))
        {
            $this->sm_type_id=4;
            $this->sm_type='instagram';
        }else{
            return back();
        }
    }

    public function feeds(Request $request)
    {
        $data['sm_type']=$this->sm_type;
        if(session('role_id')=='admin' || session('role_id')=='sadmin') {
            $data['posts']=Post::where('sm_type_id', $this->sm_type_id)->paginate(20);
        }else{
            $data['posts']=Post::where('sm_type_id',$this->sm_type_id)->where('company_id',session('company_id'))->paginate(20);
        }
        $data['pageTitle']=ucfirst($data['sm_type']).' Newsfeed';

        return view('www::feeds.index',$data);
    }
    public function details(Request $request,$post_id)
    {
        $data['sm_type']=$this->sm_type;

        if(session('role_id')=='admin' || session('role_id')=='sadmin') {
            $data['post'] = Post::where('id', $post_id)->where('sm_type_id', $this->sm_type_id)->with(['relComment', 'relPostImage'])->first();
        }else{
            $data['post'] = Post::where('id', $post_id)->where('sm_type_id', $this->sm_type_id)->where('company_id', session('company_id'))->with(['relComment', 'relPostImage'])->first();
        }
        if($data['post'] == null) return back();
        $data['pageTitle']='Post Details';
//        dd($data['post']);
//        dd($data);
        return view('www::feeds.details',$data);

    }
    public function edit($post_id)
    {
        $data['sm_type']=$this->sm_type;
        if(session('role_id')=='admin' || session('role_id')=='sadmin') {
            $data['post'] = Post::where('id', $post_id)->where('sm_type_id', $this->sm_type_id)->with(['relComment', 'relPostImage'])->first();
        }else{
            $data['post'] = Post::where('id', $post_id)->where('sm_type_id', $this->sm_type_id)->where('company_id', session('company_id'))->with(['relComment', 'relPostImage'])->first();
        }
        if($data['post'] == null) return back();
        $data['pageTitle']='Post Details';
//        dd($data['post']);
//        dd($data);
        return view('www::feeds.edit',$data);

    }
    public function update(Request $request,$post_id)
    {
        $data=$request->all();
        $post=Post::findOrFail($post_id);
        if($this->sm_type=='facebook')
        {
            $result=FacebookHelper::_updatePost($post->post_id,$data);
            if($result['success']==true){
                $post->update($data);
                Session::flash('message','Successfully updated');
                return redirect('www/feeds/facebook/'.$post_id);
            }
        }
        return back();
    }
}
