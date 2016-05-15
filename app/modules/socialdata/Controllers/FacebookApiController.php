<?php

namespace App\Modules\Socialdata\Controllers;

use App\SmType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FacebookApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        $config = [
            "appId" => '969861563097945',
            'secret' => '6aaf0ad24ca10468aa788f67f3741396',
            'default_graph_version' => 'v2.5',
        ];
        echo $_SERVER['HTTP_HOST'];
        $facebook = new \Facebook($config);
        $permissions = ['email', 'user_likes']; // optional
        $facebook->getLoginUrl(['http://'.$_SERVER['HTTP_HOST'].'/facebook-api-index'], $permissions);
        try {
            $access_token = $facebook->getAccessToken();
            $sm_type = SmType::where('type','facebook')->first();
            $sm_type['access_token'] = $access_token;
            $sm_type->update();
            /*__paging_token
            $feed = $facebook->api('/unitednations/feed');
            print_r($feed);exit;*/

        } catch(\FacebookApiException $e) {
            echo 'Facebook returned an error: ' . $e->getMessage();
            exit;
        } catch(\Exception $e){
            echo $e->getMessage();
        }
        exit;

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
