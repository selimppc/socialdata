<?php

namespace App\Modules\Socialdata\Controllers;

use App\Company;
use App\SmType;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GoogleApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //google api connect
    public function index()
    {
        //$id= '111786072963538463758';
        $user_id = 1;
        define('SCOPES', implode(' ', array(
                'https://www.googleapis.com/auth/plus.me'
            )
        ));
        $client = new \Google_Client();
        $client->setAuthConfigFile(public_path().'/apis/client_secret_974791274339-doct333hjkdob6mccquvuo21k662s7m5.apps.googleusercontent.com.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/google-api-index');
        $client->addScope(SCOPES);
        $client->setLoginHint('');
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");

        $plus = new \Google_Service_Plus($client);
        Session::put('plus',$plus);

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            Session::put('code', $_GET['code']);
            Session::put('access_token', $client->getAccessToken());
            if (Session::has('access_token')) {
                $access_token = Session::get('access_token');
                $code = Session::get('code');
                $client->setAccessToken($access_token);
                $sm_type_info = SmType::where('type','google_plus')->where('status','active')->first();
                $sm_type_info['access_token'] = $access_token;
                $sm_type_info['code'] = $code;
                DB::beginTransaction();
                try {
                    $sm_type_info->update(); // store / update / code here
                    DB::commit();
                }catch (\Exception $e) {
                    //If there are any exceptions, rollback the transaction`
                    DB::rollback();
                    print_r($e->getMessage());
                    exit();
                }
                return redirect()->route('google-plus-info');
            }
        }
        else {
            $authUrl = $client->createAuthUrl();
            return redirect()->to($authUrl);
        }
    }


    /*
     *
     *
     * */
    //Google api connect success view
    public function google_plus_info(){
        $data = "Successfully Connect to Google Api";
        return view('socialdata::google_api.success',['data' => $data]);
        exit('OK');
        /*if(Session::has('plus')){
            $plus = Session::get('plus');
            $id= '111786072963538463758';
            $me = $plus->people->get($id);
            $optParams = array('maxResults' => 100);
            $activities = $plus->activities->listActivities($id, 'public', $optParams);
            // The access token may have been updated lazily.
            //$_SESSION['access_token'] = $client->getAccessToken();
            //Session::put('access_token', $client->getAccessToken());
            foreach ($activities['items'] as $item) {
                echo 'Name : '.$me['displayName'].'<br>';
                echo 'Post url: '.$item['url'].'<br>';
                echo 'Post title: '.$item['title'].'<br>';
            }
        }*/
    }
    //Google Api connect view
    public function view(){
        $pageTitle = "Google Api Connect";
        return view('socialdata::google_api.view',['pageTitle' => $pageTitle]);
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
        //
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
        //
    }
}
