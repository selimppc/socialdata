<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 12:57 PM
 */

namespace App\Modules\Www\Controllers;

use App\Http\Controllers\Controller;
use App\CompanySocialAccount;
use App\SmType;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Helpers\SocialMediaHelper;

class SocialMediaController extends Controller
{
    public function index(){
        $data['pageTitle']='Social Media Status';
        $data['social_medias']=SmType::with(['relCompanySocialAccount'=>function($query){
            $query->where('company_id',\Session::get('companyId'));
        }])->get();

        #dd($data);
        foreach ($data['social_medias'] as $id=>$social_media) {

            foreach ($social_media->relCompanySocialAccount as $user_social_account) {
                if(empty($user_social_account->sm_account_id))
                {
                    if($user_social_account->sm_type_id==2)
                    {
                        $config = SocialMediaHelper::getFbConfig();
                        $fb = new Facebook($config);

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
                        $url= \URL::to('www/social-media-return/facebook/'.$user_social_account->id);
                        $data['social_medias'][$id]->loginUrl = $helper->getLoginUrl($url, $permissions);
                        $data['social_medias'][$id]->button_text = 'Subscribe with Facebook';
                    }else{
                        $data['social_medias'][$id]->loginUrl = '#';
                        $data['social_medias'][$id]->button_text = 'Please Subscribe';
                    }
                }else{
                    $data['social_medias'][$id]->loginUrl = '#';
                    $data['social_medias'][$id]->button_text = 'Already Subscribe';
                    foreach ($social_media->relCompanySocialAccount as $user_social_account) {
                        if($user_social_account->sm_type_id==2)
                        {
                            $data['social_medias'][$id]->user_sm_id = $user_social_account->id;
                            $data['social_medias'][$id]->button_text_data = 'Get Data';

                        }
                    }

                }
            }

        }
        return view('www::social_media.index',$data);
    }
    public function social_media_return($social_media_type,$company_social_media_id){
        if($social_media_type=='facebook')
        {
            $config=SocialMediaHelper::getFbConfig();
            $fb = new Facebook($config);

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

            $oAuth2Client= $fb->getOAuth2Client();
            $longLiveAccessToken=$oAuth2Client->getLongLivedAccessToken($accessToken);
            $fb->setDefaultAccessToken($longLiveAccessToken);

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
//dd($userNode->getId());
            /*
             * store data on user social account
             * */

            $userSocial= CompanySocialAccount::findOrFail($company_social_media_id);
            $userSocial->sm_account_id=$userNode->getId();
//            $userSocial->user_id=Auth::user()->id;
            $userSocial->access_token=$longLiveAccessToken;
            $userSocial->save();
            return redirect('www/add-social-media');

        }
    }
    public function get_posts($user_social_media_id)
    {
        $config=SocialMediaHelper::getFbConfig();
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