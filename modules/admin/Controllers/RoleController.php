<?php

namespace Modules\Admin\Controllers;

use App\Company;
use App\Helpers\LogFileHelper;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $role_title = Input::get('title');
        $pageTitle = "List of Role Informations";
        $role_id=Session::get('role_id');
        if($role_id== 'sadmin' || $role_id=='admin')
        {
            $data = Role::where('status', '!=', 'cancel')->where('title', 'LIKE', '%' . $role_title . '%')->paginate(30);
            $protected=0;
        }else {
            $data = Role::where('status', '!=', 'cancel')->where('type', '!=', 'cadmin')->where('title', 'LIKE', '%' . $role_title . '%')->where('company_id', Session::get('company_id'))->paginate(30);
            if(!empty($data) && count($data)>=1)
            {
                $protected= $data[0]->id;
            }else{
                $protected = 0;
            }

        }
        //if(isset($protected)) exit('set'); else exit('not set');
        //print_r($data);exit;
        return view('admin::role.index',['data'=>$data, 'pageTitle'=>$pageTitle,'role_type'=>$role_id,'protected'=>$protected]);

    }
    public function create()
    {
        $pageTitle = "Add new Role";
        $role_id=Session::get('role_id');
        return view('admin::role.create',['pageTitle'=>$pageTitle,'role_type'=>$role_id]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_role(Requests\RoleRequest $request)
    {
        $input = $request->all();
        $input['company_id']=Session::get('company_id');
        if($input['company_id']!=null) {
            $company_name = Company::findOrFail($input['company_id']);
            $input['title'] = $company_name->title . ' | ' . $input['title'];
        }
        $input['slug'] = str_slug(strtolower($input['title']));
        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            Role::create($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');
            LogFileHelper::log_info('store-role', 'Successfully added', ['Role title: '.$input['title']]);
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            LogFileHelper::log_error('store-role', $e->getMessage(), ['Role title: '.$input['title']]);
        }

        return redirect()->route('role');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $pageTitle = 'View Role Informations';
        $data = Role::where('slug',$slug)->first();
        return view('admin::role.view', ['data' => $data, 'pageTitle'=> $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $pageTitle = "Update Role Informations";
        $data = Role::where('slug',$slug)->first();
        $role_id=Session::get('role_id');
        return view('admin::role.update', ['data' => $data,'pageTitle'=> $pageTitle,'role_type'=>$role_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $input = $request->all();
        $input['slug'] = str_slug(strtolower($input['title']));

        $model = Role::where('slug',$slug)->first();
        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');
            LogFileHelper::log_info('update-role', 'Successfully updated.', ['Role title: '.$input['title']]);
        }catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            LogFileHelper::log_error('update-role', $e->getMessage(), ['Role title: '.$input['title']]);
        }
        //}
        return redirect()->route('role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $model = Role::where('slug',$slug)->first();
        DB::beginTransaction();
        try {
            if($model->status =='active'){
                $model->status = 'cancel';
            }else{
                $model->status = 'active';
            }
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
            LogFileHelper::log_info('delete-role', 'Successfully status cancel', ['Role title: '.$model->title]);

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
            LogFileHelper::log_error('delete-role', $e->getMessage(), ['Role title: '.$model->title]);
        }
        return redirect()->route('role');
    }
}
