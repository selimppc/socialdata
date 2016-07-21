<?php

namespace Modules\Socialdata\Controllers;

use App\Comment;
use App\Company;
use App\Post;
use App\SmType;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "All Post";
        $data = Post::orderBy('id', 'DESC')->paginate(50);
        $sm_type = [''=>'Select Social Media Type'] + SmType::where('status','!=','cancel')->lists('type','id')->all();
        $company = [''=>'Select Comapny'] + Company::where('status','!=','cancel')->lists('title','id')->all();
        return view('socialdata::post.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'sm_type'=>$sm_type,'company'=>$company]);
    }

    public function search_post(){

        $pageTitle = "All post";

        $company_name = Input::get('company_name');
        $sm_type = Input::get('sm_type');
        $post_mention = Input::get('post_mention');
        $sm = SmType::findOrFail($sm_type);
        $data = new Post();

        $data = $data->select('post.*');
        if(isset($company_name) && !empty($company_name)){
            $data = $data->leftJoin('company','company.id','=','post.company_id');
            $data = $data->where('company.id', $company_name);
        }
        if(isset($sm_type) && !empty($sm_type)){
            $data = $data->leftJoin('sm_type','sm_type.id','=','post.sm_type_id');

            if(strtolower($sm->type) == 'twitter'){
                if($post_mention == 'mention') {
                    $data = $data->where('sm_type.id', $sm_type)
                        ->where('mention', 1);
                }else{
                    $data = $data->where('sm_type.id', $sm_type)
                        ->where('mention', 0);
                }
            }else {
                $data = $data->where('sm_type.id', $sm_type);
            }
        }
        $data = $data->paginate(50);

        $sm_type = [''=>'Select Social Media Type'] + SmType::where('status','!=','cancel')->lists('type','id')->all();
        $company = [''=>'Select Comapny'] + Company::where('status','!=','cancel')->lists('name','id')->all();
        return view('socialdata::post.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'sm_type'=>$sm_type,'company'=>$company, 'post_mention' => $post_mention]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'View post';
        $data = Post::where('id',$id)->first();

        return view('socialdata::post.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Update post';
        $data = Post::where('id',$id)->first();
        return view('socialdata::post.update', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Post::findOrFail($id);

        DB::beginTransaction();
        try {
            $model->delete();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
        }
        //return redirect()->route('index-company-social-account');
        return redirect()->back();
    }
    /**
     * export specific database table
    */
    public function export_post_index(){
        $pageTitle = 'Export post';
        $data = null;
        $company_list = [''=>'Select Comapny'] + Company::where('status','!=','cancel')->lists('name','id')->all();
        $sm_type_list = [''=>'Select Social Media Type'] + SmType::where('status','!=','cancel')->lists('type','id')->all();

        return view('socialdata::export_post.view', ['data' => $data, 'pageTitle'=> $pageTitle, 'company_list'=>$company_list, 'sm_type_list'=> $sm_type_list]);
    }

    public function export_post_csv(){
        $company_id = Input::get('company_id');
        $sm_type_id = Input::get('sm_type_id');
        $sm = SmType::findOrFail($sm_type_id);
        $post_mention = Input::get('post_mention');

        $button = Input::get('export_button');
        if($button == 'Export Post'){
            $filename = public_path()."/post.csv";
            $handle = fopen($filename, 'w');
            fputcsv($handle, array('id', 'post', 'created at'));

            if(strtolower($sm->type) == 'twitter'){
                if($post_mention == 'post') {
                    $company_post = Post::where('company_id', $company_id)
                        ->where('sm_type_id', $sm_type_id)
                        ->where('mention', 0)
                        ->get();
                }else{
                    $company_post = Post::where('company_id', $company_id)
                        ->where('sm_type_id', $sm_type_id)
                        ->where('mention', 1)
                        ->get();
                }
            }else {
                $company_post = Post::where('company_id', $company_id)
                    ->where('sm_type_id', $sm_type_id)
                    ->get();
            }
            foreach ($company_post as $post) {
                fputcsv($handle, array($post->id, $post->post, $post->post_date));
            }
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            if(fileperms($filename) != 0755){
                umask(0);
                chmod($filename, 0755);
            }
            $company_name = Company::where('id',$company_id)->first();
            $sm_type_name = SmType::where('id',$sm_type_id)->first();
            if(strtolower($sm->type) == 'twitter' && $post_mention == 'mention'){
                $csv_name = $company_name['name'] . '-' . $sm_type_name['type'] . '-mention.csv';
            }else {
                $csv_name = $company_name['name'] . '-' . $sm_type_name['type'] . '-post.csv';
            }
            return Response::download($filename, $csv_name, $headers);
        }else{
            $filename = public_path()."/comment.csv";
            $handle = fopen($filename, 'w');
            fputcsv($handle, array('id', 'post-id', 'comment', 'created at'));

            $company_post = Post::where('company_id',$company_id)->get();

            foreach ($company_post as $post) {
                $comments = Comment::where('post_id',$post->id)->get();
                foreach ($comments as $comment) {
                    fputcsv($handle, array($comment->id, $comment->post_id, $comment->comment, $comment->comment_date));
                }
            }
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            if(fileperms($filename) != 0755){
                umask(0);
                chmod($filename, 0755);
            }
            $company_name = Company::where('id',$company_id)->first();
            $sm_type_name = SmType::where('id',$sm_type_id)->first();
            return Response::download($filename, $company_name['name'].'-'.$sm_type_name['type'].'-comment.csv', $headers);
        }


        exit;
    }

    public function api_post($company_id = null, $sm_type_id = null){
        $limit = Input::get('limit') ?: 20;
        $max_limit = 20;
        if($limit <= $max_limit){
            if ($company_id != null && $sm_type_id != null) {
                //$posts = App\Product::all(array('id', 'name', 'price'));
                $posts = Post::where('company_id',$company_id)
                    ->where('sm_type_id',$sm_type_id)
                    ->select('post','post_date')
                    ->paginate($limit)
                    ->toArray();
                $error = false;
            } else {
                $posts = 'No request found';
                $error = true;
            }
        }
        else{
            $error = true;
            $posts = ['max limit cross'];
        }
        return Response::json(array(
            'error' => $error,
            'posts' => $posts,
        ))->setCallback(Input::get('callback'));
    }

    public function api_post_search($company_id = null, $sm_type_id = null, $text = null){
        $limit = Input::get('limit') ?: 20;
        $max_limit = 20;
        if($limit <= $max_limit){
            if ($company_id != null && $sm_type_id != null) {
                //$posts = App\Product::all(array('id', 'name', 'price'));
                $posts = Post::where('company_id',$company_id)
                    ->where('sm_type_id',$sm_type_id)
                    ->where('post','LIKE', '%'.$text.'%')
                    ->select('post','post_date')
                    ->paginate($limit)
                    ->toArray();
                $error = false;
            } else {
                $posts = 'No request found';
                $error = true;
            }
        }else{
            $posts = ['max limit cross'];
            $error = true;
        }
        return Response::json(array(
            'error' => $error,
            'data' => $posts,
        ))->setCallback(Input::get('callback'));
    }
}
