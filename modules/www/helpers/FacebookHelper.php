<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/5/16
 * Time: 11:52 AM
 */

namespace App\Helpers;

use App\Comment;
use App\CompanySocialAccount;
use App\CustomPost;
use App\Post;
use App\PostImage;
use App\PostSocialMedia;
use Illuminate\Support\Facades\Config;
use Facebook\Facebook;
use Illuminate\Support\Facades\DB;

class FacebookHelper
{
    public static function getFbConfig()
    {
        @session_start();
        $fb_config=Config::get('socialdata.facebook');
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
        $permissions=Config::get('settingData.permissions');
        $callback=Config::get('settingData.callback').'/facebook';
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
            $pages=$fb->get('/me/accounts');
            $pages=$pages->getGraphEdge()->asArray();

            $response = $fb->get('/me');
            $userNode = $response->getGraphUser();
            return ['userNode'=>$userNode,'longLiveAccessToken'=>$longLiveAccessToken,'pages'=>$pages];
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
        }
    }
    public static function publish($post_id,$company_id=false)
    {
        $config= FacebookHelper::getFbConfig();
        if($company_id==false)
        {
            $company_id=session('company_id');
        }
        $fb_account= CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id',2)->first();

        $fb= new Facebook($config);
        $fb->setDefaultAccessToken($fb_account->access_token);
        $pages=$fb->get('/me/accounts');
        $pages=$pages->getGraphEdge()->asArray();
//        dd($pages);
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
        }else{
            return 'Page owner error';
        }
        return false;
    }
    // retrieve page data

    public static function getPosts( $access_token,$page_id)	{
        if ( !empty($access_token) )	{
            $config = FacebookHelper::getFbConfig();
            $fb= new Facebook($config);
            $fb->setDefaultAccessToken($access_token);
            try {
                // Returns a `Facebook\FacebookResponse` object
                return $fb->get("/$page_id/posts?fields=attachments,message,created_time", $access_token);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        }
        return false;
    }
    public static function storeData($data,$company_social_account)
    {
        $message=[];
        foreach ($data as $id=>$item) {
            DB::beginTransaction();
            try {
                $post = Post::where('post_id', $item['id'])->where('sm_type_id', 2)->first();
                if (count($post) == 0) {
                    $post = new Post();
                    $post->company_id = $company_social_account->company_id;
                    $post->sm_type_id = $company_social_account->sm_type_id;
                    $post->post = isset($item['message']) ? $item['message'] : "";
                    $post->post_id = $item['id'];
                    $post->post_date = $item['created_time'];
//                    dd($post);
                    $post->save();
                    print "    Post Save \n";
//                    dd($item['attachments']);
//                    dd($item);
                    if (isset($item['attachments'])) {
                        FacebookHelper::_attachments($post, $item);
                    }

                }
                $comments = FacebookHelper::_getComments($post->id);
                if (isset($comments) && !emptyArray($comments)) {
                    FacebookHelper::_storeComments($post->id, $comments);
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                $message[$item->id]=$e->getMessage();
            }
        }
        return $message;
    }
    private static function _attachments($post,$item)
    {
        foreach ($item['attachments']['data'] as $id=>$attachment) {
            if(isset($attachment['subattachments']))
            {
                foreach ($attachment['subattachments']['data'] as $id=>$subattachment) {
                    $post_image = new PostImage();
                    $post_image->post_id = $post->id;
                    $post_image->description = isset($subattachment['description'])?$subattachment['description']:'';
                    $post_image->url_standard = $subattachment['media']['image']['src'];
                    $post_image->save();
                }
            }else {
                $post_image = new PostImage();
                $post_image->post_id = $post->id;
                $post_image->description = isset($attachment['description'])?$attachment['description']:'';
                $post_image->url_standard = $attachment['media']['image']['src'];
                    $post_image->save();
            }
            print "         Image Save \n";
        }
    }
    private static function _getComments($post_id)
    {
        $post= Post::findOrFail($post_id);
        $company_social_account= CompanySocialAccount::where('company_id',$post->company_id)->where('sm_type_id',2)->first();
        $config = FacebookHelper::getFbConfig();
        $fb= new Facebook($config);
        if($company_social_account !=null) {
            $fb->setDefaultAccessToken($company_social_account->access_token);
//        dd($post->post_id);
            return $fb->get("/" . $post->post_id . "/comments", $company_social_account->access_token);
        }else{
            return [];
        }
    }
    private static function _storeComments($post_id,$comments)
    {
        $comments=$comments->getDecodedBody('data');
        foreach ($comments['data'] as $id=>$comment) {
            if(!Comment::where('comment_id',$comment['id'])->exists()) {
                $c = new Comment();
                $c->post_id = $post_id;
                $c->comment_id = $comment['id'];
                $c->comment = $comment['message'];
                $c->comment_date = $comment['created_time'];
                $c->save();
                print "             Comment Save \n";
            }
        }
    }
    public static function metric($access_token,$page_id)
    {
        $config= FacebookHelper::getFbConfig();
        $fb= new Facebook($config);
        $fb->setDefaultAccessToken($access_token);
        $insights = $fb->get($page_id.'/insights/page_suggestion');
        dd($insights);

    }
}