<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 3/2/16
 * Time: 4:04 PM
 */

namespace App\Modules\User\Controllers;


use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{

    protected function isGetRequest()
    {
        return Input::server("REQUEST_METHOD") == "GET";
    }

    public function index()
    {
        $pageTitle = "List of Departments";
        $model = Department::paginate(30);

        return view('user::department.index',['pageTitle'=>$pageTitle,'model'=>$model]);
    }

    public function store(DepartmentRequest $request){

        $input = $request->all();

        $input['slug'] = str_slug(strtolower($input['title']));

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            Department::create($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');

        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
        }

        return redirect()->back();
    }

    public function search_department(){

        $pageTitle = "Department Informations";

        if($this->isGetRequest()){
            $title = Input::get('title');
            $status = Input::get('status');
            $model = new Department();

            $model = $model->select('department.*');
            if(isset($title) && !empty($title)){

                $model = $model->where('title', 'like', '%' . Input::get('title') . '%');
            }
            if(isset($status) && !empty($status)){
                $model = $model->where('status', '=', $status);
            }
            $model = $model->paginate(30);
        }else{
            $model = Department::paginate(30);
        }

        return view('user::department.index', ['model' => $model, 'pageTitle'=> $pageTitle]);
    }

    public function view($id)
    {
        $pageTitle = 'Department Informations';
        $data = Department::where('id',$id)->first();
        return view('user::department.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    public function edit($id)
    {
        $pageTitle = "Update Department Informations";
        $data = Department::where('id',$id)->first();
        return view('user::department.update', ['data' => $data,'pageTitle'=> $pageTitle]);
    }

    public function update(DepartmentRequest $request,$id)
    {

        $input = $request->all();
        $input['slug'] = str_slug(strtolower($input['title']));

        $model = Department::where('id',$id)->first();
        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');

        }catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
        }
        //}
        return redirect()->route('department');
    }

    public function delete($id)
    {
        $model = Department::where('id',$id)->first();
        DB::beginTransaction();
        try {
            $model->delete();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
        }
        return redirect()->route('department');
    }
}