<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/5/16
 * Time: 11:52 AM
 */

namespace App\Helpers;

use App\CompanySocialAccount;
use App\CustomPost;
use App\PostSocialMedia;
use Illuminate\Support\Facades\Config;
use Facebook\Facebook;

class FacebookHelper
{
    public static function getFbConfig()
    {
        @session_start();
        $fb_config=Config::get('custom.facebook');
        $config = [
            'app_id' => $fb_config['app_id'],
            'app_secret' => $fb_config['app_secret'],
            'default_graph_version' => 'v2.6',
            'persistent_data_handler'=>'session'
        ];
        return $config;
    }
    public static function getLoginUrl()
    {
        $config = FacebookHelper::getFbConfig();
        $fb = new Facebook($config);

        $helper = $fb->getRedirectLoginHelper();
        // Optional permissions
        $permissions=Config::get('custom.permissions');
        $callback=Config::get('custom.callback').'/facebook';
        $callback= url($callback);
//        $url= \URL::to('www/social-media-return/facebook/'.$user_social_account_id);
        return $helper->getLoginUrl($callback, $permissions);

    }
    public static function _return()
    {
        $config=FacebookHelper::getFbConfig();
        $fb = new Facebook($config);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
        }

        $oAuth2Client= $fb->getOAuth2Client();
        $longLiveAccessToken=$oAuth2Client->getLongLivedAccessToken($accessToken);
        $fb->setDefaultAccessToken($longLiveAccessToken);

        try {
            $response = $fb->get('/me');
            $userNode = $response->getGraphUser();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
        }
        return ['userNode'=>$userNode,'longLiveAccessToken'=>$longLiveAccessToken];
    }
    public static function publish($post_id,$company_id=false)
    {
        $config= FacebookHelper::getFbConfig();
        if($company_id==false)
        {
            $company_id=session('companyId');
        }
        $fb_account= CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id',2)->first();

        $fb= new Facebook($config);
        $fb->setDefaultAccessToken($fb_account->access_token);
        $pages=$fb->get('/me/accounts');
        $pages=$pages->getGraphEdge()->asArray();
        $page_access_token= null;
        $page_id= null;
        foreach ($pages as $page) {
            if($page['id']==$fb_account->page_id){
                $page_access_token=$page['access_token'];
                $page_id=$page['id'];
            }
        }
        if($page_access_token!=null && $page_id!=null)
        {
            try{
                $custom_post=CustomPost::findOrFail($post_id);
                $post=$fb->post('/'.$page_id.'/feed',['message'=>$custom_post->text],$page_access_token);
                $post=$post->getGraphNode()->asArray();
                if(isset($post['id']))
                {
                    $p=explode('_',$post['id']);
                    $post_social_media=PostSocialMedia::where('custom_post_id',$post_id)->where('social_media_id',2)->first();
                    $post_social_media->postId=$p[1];
                    $post_social_media->status='sent';
                    $post_social_media->save();
                    return 'success';
                }
            }catch (Exception $e)
            {
                return $e;
            }
        }
        return false;
    }

}