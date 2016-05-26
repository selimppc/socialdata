<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 12:57 PM
 */

namespace App\Modules\Www\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Www\Models\UserSocialAccount;
use App\SmType;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{
    public function index(){
        $data['pageTitle']='Social Media Status';
        $data['social_medias']=SmType::with('relUserSocialAccount')->get();

//dd(count($data['social_medias']->relUserSocialAccount));
        foreach ($data['social_medias'] as $id=>$social_media) {
            if(isset($social_media->relUserSocialAccount) && count($social_media->relUserSocialAccount)==0)
            {
                if($social_media->id==2)
                {
                    $config = [
                        'appId' => '969861563097945',
                        'secret' => '6aaf0ad24ca10468aa788f67f3741396',
                        //'default_graph_version' => 'v2.5',
                    ];
                    $fb = new \Facebook($config);
                    dd($fb);
                    $helper = $fb->getRedirectLoginHelper();
                    $permissions = [
                        'public_profile',
                        'user_friends',
                        'email',
                        'user_about_me',
                        'user_actions.books',
                        'user_actions.fitness',
                        'user_actions.music',
                        'user_actions.news',
                        'user_actions.video',
//user_actions:{app_namespace}
                        'user_birthday',
                        'user_education_history',
                        'user_events',
                        'user_games_activity',
                        'user_hometown',
                        'user_likes',
                        'user_location',
                        'user_managed_groups',
                        'user_photos',
                        'user_posts',
                        'user_relationships',
                        'user_relationship_details',
                        'user_religion_politics',
                        'user_tagged_places',
                        'user_videos',
                        'user_website',
                        'user_work_history',
                        'read_custom_friendlists',
                        'read_insights',
                        'read_audience_network_insights',
                        'read_page_mailboxes',
                        'manage_pages',
                        'publish_pages',
                        'publish_actions',
                        'rsvp_event',
                        'pages_show_list',
                        'pages_manage_cta',
                        'pages_manage_instant_articles',
                        'ads_read',
                        'ads_management',
                        'pages_messaging',
                        'pages_messaging_phone_number'
                    ]; // Optional permissions
                    $url= URL::to('www/social_media_return/facebook');
                    //$data['social_medias'][$id]->loginUrl = $helper->getLoginUrl('http://demo2.yourworkupdate.com/fbshare/action.php', $permissions);
                    $data['social_medias'][$id]->loginUrl = $helper->getLoginUrl($url, $permissions);
                    $data['social_medias'][$id]->button_text = 'Subscribe with Facebook';
                }else{
                    $data['social_medias'][$id]->loginUrl = '#';
                    $data['social_medias'][$id]->button_text = 'Please Subscribe';
                }
            }else{
                $data['social_medias'][$id]->loginUrl = '#';
                $data['social_medias'][$id]->button_text = 'Already Subscribe';
            }
        }



        //$data['active_medias']=UserSocialAccount::where('user_id',Auth::user()->id)->get();
        //dd($data);
        return view('www::social_media.index',$data);
    }
    public function social_media_return($social_media_type){
        if($social_media_type=='facebook')
        {
//            $user_fb_id='Rahullovesmmh';
//            $user_fb_id='100011542261752';
//            $user_fb_id='100000059945383';
            $config = [
                'appId' => '969861563097945',
                'secret' => '6aaf0ad24ca10468aa788f67f3741396',
                //'default_graph_version' => 'v2.5',
            ];
            $fb = new \Facebook($config);

            $helper = $fb->getRedirectLoginHelper();

            try {
                $accessToken = $helper->getAccessToken();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $fb->setDefaultAccessToken($accessToken);

            try {
                $response = $fb->get('/me');
                $userNode = $response->getGraphUser();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            /*
             * store data on user social account
             * */

            $userSocial= new UserSocialAccount();
            $userSocial->sm_account_id=$userNode->getId();
            $userSocial->user_id=Auth::user()->id;
            $userSocial->sm_type_id= 2;
            $userSocial->status= 'active';
            $userSocial->save();

            echo 'Logged in as ' . $userNode->getId();

            //https://graph.facebook.com/me?fields=id&access_token="xxxxx"


            $limit = 20;

            // FB first call to get pagination next var
            $feed = $fb->api("/$userNode->getId()/posts?limit=$limit");
            dd($feed);
        }
    }

}