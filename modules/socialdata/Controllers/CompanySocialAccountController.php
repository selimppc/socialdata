<?php

namespace Modules\Socialdata\Controllers;

use App\ArchiveSchedule;
use App\Company;
use App\CompanySocialAccount;
use App\CustomPost;
use App\Post;
use App\PostSocialMedia;
use App\Schedule;
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

        $data = CompanySocialAccount::where('company_id',$company_id)->orderBy('id', 'DESC')->paginate(50);
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
        $check_existing= CompanySocialAccount::where('sm_account_id',$input['sm_account_id'])->where('page_id',$input['page_id'])->first();
        if(count($check_existing)==0) {
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
            if (session('company_id') == null) {
                return redirect()->to('index-company-social-account/' . $input['company_id']);
            } else {
                return redirect()->to('index-company-social-account');
            }
        }else{
            Session::flash('danger', 'Sorry,This Page/Account already exist. Please try with new one.');
            return redirect()->back();
        }
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

        if(session('company_id')==null)
        {
            return redirect()->to('index-company-social-account/'.$input['company_id']);
        }else{
            return redirect()->to('index-company-social-account');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $companySocialAccount = CompanySocialAccount::select('sm_type_id','company_id')->where('id',$id)->first();

        DB::beginTransaction();
        try {
            $postSocialMedia = PostSocialMedia::where('company_id', $companySocialAccount->company_id)->where('social_media_id', $companySocialAccount->sm_type_id)->get();
            foreach ($postSocialMedia as $psm) {
                $checkPost = PostSocialMedia::where('custom_post_id', $psm->custom_post_id)->get();
                echo $psm->id.'-';
                echo count($checkPost).'<br>';
                if (count($checkPost) == 1) {
//                    dd($psm->custom_post_id);
                    Schedule::where('custom_post_id', $psm->custom_post_id)->delete();
                    ArchiveSchedule::where('custom_post_id', $psm->custom_post_id)->delete();
                    Post::where('id',$psm->custom_post_id)->delete();
                }
            }
            PostSocialMedia::where('company_id', $companySocialAccount->company_id)->where('social_media_id', $companySocialAccount->sm_type_id)->delete();
            CompanySocialAccount::select('sm_type_id','company_id')->where('id',$id)->delete();
            DB::commit();
            Session::flash('message', "Successfully Deleted.");

        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
        }
        //return redirect()->route('index-company-social-account');
        return redirect()->back();
    }
    public function change_status($id,$status)
    {
        $model = CompanySocialAccount::findOrFail($id);

        DB::beginTransaction();
        try {
                $model->status = $status;
            $model->save();
            DB::commit();
            Session::flash('message', "Successfully Change Status.");
        } catch(\Exception $e) {
            DB::rollback();
            Session::flash('danger',$e->getMessage());
        }
        //return redirect()->route('index-company-social-account');
        return redirect()->back();
    }

}
