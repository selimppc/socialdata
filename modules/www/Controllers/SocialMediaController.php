<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 12:57 PM
 */

namespace Modules\Www\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Helpers\GooglePlusHelper;
use App\Helpers\TwitterHelper;
use App\Http\Controllers\Controller;
use App\CompanySocialAccount;
use App\SmType;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Helpers\FacebookHelper;
use Illuminate\Support\Facades\Session;

class SocialMediaController extends Controller
{
    public function index(){
        $data['pageTitle']='Social Media Status';
//        $data['social_medias']=SmType::with(['relCompanySocialAccount'])->get();
        $data['social_medias']=CompanySocialAccount::with(['relSmType'])->where('company_id',Session::get('company_id'))->get();

        #dd($data);
//        foreach ($data['social_medias'] as $id=>$social_media) {
//            foreach ($social_media->relCompanySocialAccount as $user_social_account) {
//                if(empty($user_social_account->sm_account_id))
//                {
//                    Session::put('user_social_account_id',$user_social_account->id);
//                    if($user_social_account->sm_type_id==2)
//                    {
//                        $loginUrl= FacebookHelper::getLoginUrl();
//                        $data['social_medias'][$id]->loginUrl = $loginUrl;
//                        $data['social_medias'][$id]->button_text = 'Subscribe with Facebook';
//                    }elseif($user_social_account->sm_type_id==3){
//                        $loginUrl= TwitterHelper::getLoginUrl();
//                        $data['social_medias'][$id]->loginUrl = $loginUrl;
//                        $data['social_medias'][$id]->button_text = 'Subscribe with Twitter';
//                    }elseif($user_social_account->sm_type_id==1){
//                        $loginUrl= GooglePlusHelper::getLoginUrl($user_social_account->id);
//                        $data['social_medias'][$id]->loginUrl = $loginUrl;
//                        $data['social_medias'][$id]->button_text = 'Subscribe with Google+';
//                    }
//                    $data['social_medias'][$id]->btnClass='info';
//                }else{
//                    $data['social_medias'][$id]->loginUrl = '#';
//                    $data['social_medias'][$id]->button_text = 'Already Subscribe';
//                    /*foreach ($social_media->relCompanySocialAccount as $user_social_account) {
//                        if($user_social_account->sm_type_id==2)
//                        {
//                            $data['social_medias'][$id]->user_sm_id = $user_social_account->id;
//                            $data['social_medias'][$id]->button_text_data = 'Get Data';
//
//                        }
//                    }*/
//                    $data['social_medias'][$id]->btnClass='primary';
//
//                }
//            }
//
//        }
        foreach ($data['social_medias'] as $id=>$social_media) {
            if(empty($social_media->sm_account_id)){
                Session::put('user_social_account_id',$social_media->id);
                if($social_media->sm_type_id==2)
                {
                    $loginUrl= FacebookHelper::getLoginUrl();
                    $data['social_medias'][$id]->loginUrl = $loginUrl;
                    $data['social_medias'][$id]->button_text = 'Subscribe with Facebook';
                }elseif($social_media->sm_type_id==3){
                    $loginUrl= TwitterHelper::getLoginUrl();
                    $data['social_medias'][$id]->loginUrl = $loginUrl;
                    $data['social_medias'][$id]->button_text = 'Subscribe with Twitter';
                }elseif($social_media->sm_type_id==1){
                    $loginUrl= GooglePlusHelper::getLoginUrl($social_media->id);
                    $data['social_medias'][$id]->loginUrl = $loginUrl;
                    $data['social_medias'][$id]->button_text = 'Subscribe with Google+';
                }
                $data['social_medias'][$id]->btnClass='info';
            }else{
                $data['social_medias'][$id]->loginUrl = '#';
                $data['social_medias'][$id]->button_text = 'Already Subscribe';
                $data['social_medias'][$id]->btnClass='primary';
            }
        }
        return view('www::social_media.index',$data);
    }
    public function social_media_return($social_media_type){
//        dd(Session::get('user_social_account_id'));
        if(Session::has('user_social_account_id')) {
            $company_social_account_id = Session::get('user_social_account_id');
//            $company_social_account_id=1;
            if ($social_media_type == 'facebook') {
                $status = FacebookHelper::_return();
                if (isset($status) && isset($status['userNode']) && isset($status['longLiveAccessToken'])) {
                    /*
                     * store data on user social account
                     * */
                    $userSocial = CompanySocialAccount::findOrFail($company_social_account_id);
                    $userSocial->sm_account_id = $status['userNode']->getId();
                    $userSocial->access_token = $status['longLiveAccessToken'];
                    $userSocial->save();
                    \Session::flash('message', 'Successfully Subscribe.');

                } else {
                    Session::flash('error', $status);
                }
            }
            elseif ($social_media_type == 'twitter') {
                if (Session::has('oauth_token') && Session::has('oauth_token_secret') && isset($_REQUEST) && $_REQUEST['oauth_token'] == session('oauth_token')) {
                    $status = TwitterHelper::_return();
                    if (isset($status) && isset($status['oauth_token']) && isset($status['oauth_token_secret']) && isset($status['user_id'])) {
                        /*
                         * store data on user social account
                         * */

                        $userSocial = CompanySocialAccount::findOrFail($company_social_account_id);
                        $userSocial->sm_account_id = $status['user_id'];
                        $userSocial->access_token = $status['oauth_token'];
                        $userSocial->associate_token = $status['oauth_token_secret'];
                        $userSocial->save();
                        \Session::flash('message', 'Successfully Subscribe.');

                    } else {
                        Session::flash('error', $status);
                    }
                }
            }
            elseif ($social_media_type == 'google') {
                $status = GooglePlusHelper::_return();
                if(isset($status) && isset($status['refresh_token']) && isset($status['user_id'])) {
                    /*
                     * store data on user social account
                     * */

                    $userSocial = CompanySocialAccount::findOrFail($company_social_account_id);
                    $userSocial->sm_account_id = $status['user_id'];
                    $userSocial->access_token = $status['refresh_token'];
                    $userSocial->save();
                    \Session::flash('message', 'Successfully Subscribe.');

                } else {
                    Session::flash('error', 'Sorry, refresh token missing !');
                }
            }
        }else{
            \Session::flash('error', 'Sorry session destroyed. Please try again.');
        }
        return redirect('www/add-social-media');
    }
    public function get_posts($user_social_media_id)
    {
        $config=FacebookHelper::getFbConfig();
        $fb = new Facebook($config);
        $app_data= CompanySocialAccount::findOrFail($user_social_media_id);

        $posts=$fb->get($app_data->sm_account_id.'/posts?limit=500',$app_data->access_token);

        $total_post=[];
        $posts_response=$posts->getGraphEdge();
        if($fb->next($posts_response))
        {
            foreach ($fb->next($posts_response) as $values) {
                dd($values);
            }

        }
        dd($posts_response);
    }

}