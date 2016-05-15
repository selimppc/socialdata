<?php

namespace App\Modules\Socialdata\Controllers;

use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        $pageTitle = "Post Comments";
        $data = Comment::where('post_id',$post_id)->orderBy('id', 'DESC')->paginate(50);
        /*$sm_type = [''=>'Select Social Media Type'] + SmType::where('status','!=','cancel')->lists('type','id')->all();
        $company = [''=>'Select Comapny'] + Company::where('status','!=','cancel')->lists('name','id')->all();*/
        return view('socialdata::comment.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'post_id'=> $post_id]);
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
        $pageTitle = 'View post comment';
        $data = Comment::where('id',$id)->first();

        return view('socialdata::comment.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $model = Comment::findOrFail($id);

        DB::beginTransaction();
        try {
            $model->delete();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
        }
        return redirect()->back();
    }

    public function delete_comment_post(){
        DB::statement("SET foreign_key_checks = 0");
        DB::beginTransaction();
        try{
            DB::table('comment')->truncate();
            DB::table('post')->truncate();
            DB::commit();
            Session::flash('message', "Post and Comments Successfully Deleted");
        }catch(\Exception $ex){
            DB::rollback();
            Session::flash('danger', $ex->getMessage());
        }
        return redirect()->route('index-post');
    }
}
