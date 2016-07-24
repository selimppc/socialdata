<?php

namespace Modules\Socialdata\Controllers;

use App\Company;
use App\CompanySocialAccount;
use App\SmType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
/*use Symfony\Component\HttpFoundation\Session\Session;*/
use Illuminate\Support\Facades\Session;

class CompanySocialAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    /**
     * Display a listing of the resource.
     * @param $company_id
     * @return \Illuminate\Http\Response
     */
    public function index($company_id=false)
    {
        // Filter if a user or cadmin try to access another company info
        if((session('role_id') != 'admin' && session('role_id') != 'sadmin') && $company_id != false)
        {
            return redirect()->back();
        }
        // Get company ID
        if(isset($company_id) && empty($company_id))
        {
            $company_id=Session::get('company_id');
        }
        // Define Company ID NULL or real value
        if($company_id==null)
        {
            return redirect()->back();
        }
        $pageTitle = "Company Social Media Account Informations";

        $data = CompanySocialAccount::where('company_id',$company_id)->where('status','!=','cancel')->orderBy('id', 'DESC')->paginate(50);
        $sm_type = SmType::where('status','!=','cancel')->lists('type','id')->all();
        $company_info = Company::where('status','!=','cancel')->lists('title','id')->all();
        $company= Company::findOrFail($company_id);
        return view('socialdata::company_social_account.index', ['data' => $data, 'pageTitle'=> $pageTitle, 'sm_type' => $sm_type, 'company_info' => $company_info, 'company_id' => $company_id,'company'=>$company]);
    }
    public function create($company_id)
    {
        $pageTitle = "Add Company Social Media Account";

        $data = CompanySocialAccount::where('company_id',$company_id)->where('status','!=','cancel')->orderBy('id', 'DESC')->paginate(50);
        $sm_type = SmType::where('status','!=','cancel')->lists('type','id')->all();
        $company_info = Company::where('status','!=','cancel')->lists('title','id')->all();
        return view('socialdata::company_social_account.create', ['data' => $data, 'pageTitle'=> $pageTitle, 'sm_type' => $sm_type, 'company_info' => $company_info, 'company_id' => $company_id]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CompanySocialAccountRequest $request)
    {
        $input = $request->all();

        /* Transaction Start Here */
        DB::beginTransaction();
        try {
            CompanySocialAccount::create($input);
            DB::commit();
            Session::flash('message', 'Successfully added!');
        } catch (\Exception $e) {
            //If there are any exceptions, rollback the transaction`
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            return redirect()->back();
        }

        return redirect()->to('index-company-social-account/'.$input['company_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'View Company Social Media Account Informations';
        $data = CompanySocialAccount::where('id',$id)->first();
        $company_id = $data['company_id'];

        return view('socialdata::company_social_account.view', ['data' => $data, 'pageTitle'=> $pageTitle, 'company_id' => $company_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Update Company Social Media Account Informations';
        $data = CompanySocialAccount::where('id',$id)->first();
        $sm_type = SmType::where('status','!=','cancel')->lists('type','id')->all();
        $company_id = $data['company_id'];
        /*$company_info = Company::where('status','!=','cancel')->lists('name','id')->all();*/
        return view('socialdata::company_social_account.update', ['data' => $data, 'pageTitle'=> $pageTitle, 'sm_type' => $sm_type, 'company_id' => $company_id]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CompanySocialAccountRequest $request, $id)
    {
        $model = CompanySocialAccount::where('id',$id)->first();
        $input = $request->all();
        DB::beginTransaction();
        try {
            $model->update($input);
            DB::commit();
            Session::flash('message', "Successfully Updated");
        }
        catch ( Exception $e ){
            //If there are any exceptions, rollback the transaction
            DB::rollback();
            Session::flash('danger', $e->getMessage());
            return redirect()->back();
        }

        return redirect()->to('index-company-social-account/'.$input['company_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $model = CompanySocialAccount::findOrFail($id);

        DB::beginTransaction();
        try {
            if($model->status =='active' || $model->status =='inactive'){
                $model->status = 'cancel';
            }else{
                $model->status = 'active';
            }
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");
        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
        }
        //return redirect()->route('index-company-social-account');
        return redirect()->back();
    }

}
