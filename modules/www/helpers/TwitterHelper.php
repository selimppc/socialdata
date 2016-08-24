<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/5/16
 * Time: 12:11 PM
 */

namespace App\Helpers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Comment;
use App\CompanySocialAccount;
use App\CustomPost;
use App\Post;
use App\PostImage;
use App\PostSocialMedia;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;

class TwitterHelper
{
    public static function getTwitterConfig()
    {
        $twitter_config=Config::get('socialdata.twitter');
        $config = [
            'consumerKey' => $twitter_config['consumerKey'],
            'consumerSecret' => $twitter_config['consumerSecret'],
            'outhToken' => $twitter_config['outhToken'],
            'othTokenSecret' => $twitter_config['othTokenSecret']
        ];
        return $config;
    }
    public static function getTwitterSetting()
    {
        $twitter_config=Config::get('socialdata.twitter');
        $config = [
            'consumer_key' => $twitter_config['consumerKey'],
            'consumer_secret' => $twitter_config['consumerSecret'],
            'oauth_access_token' => $twitter_config['outhToken'],
            'oauth_access_token_secret' => $twitter_config['othTokenSecret']
        ];
        return $config;
    }
    public static function getLoginUrl(){
        $twitter_config=Config::get('socialdata.twitter');
        $callback=Config::get('settingData.callback').'/twitter';
        $callback= url($callback);
        $ttr= new TwitterOAuth($twitter_config['consumerKey'],$twitter_config['consumerSecret']);
        $request_token= $ttr->oauth('oauth/request_token',['oauth_callback'=>$callback]);
        Session::put('oauth_token',$request_token['oauth_token']);
        Session::put('oauth_token_secret',$request_token['oauth_token_secret']);
        $loginUrl= $ttr->url('oauth/authorize',['oauth_token'=>$request_token['oauth_token']]);
        return $loginUrl;

    }
    public static function _return()
    {
        try {
            $twitter_config = Config::get('socialdata.twitter');
            $ttr = new TwitterOAuth($twitter_config['consumerKey'], $twitter_config['consumerSecret'], session('oauth_token'), session('oauth_token_secret'));
            $access_token = $ttr->oauth('oauth/access_token', ['oauth_verifier' => $_REQUEST['oauth_verifier']]);
            return $access_token;
        }catch (Exception $e){
            return $e->getMessage();
        }


    }
    public static function publish($post_id,$company_id=false){
        try {
            if($company_id==false)
            {
                $company_id=session('company_id');
            }
            $twitter_config = Config::get('socialdata.twitter');
            $ttr_account = CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id', 3)->first();
            $ttr = new TwitterOAuth($twitter_config['consumerKey'], $twitter_config['consumerSecret'], $ttr_account->access_token, $ttr_account->associate_token);
            $custom_post=CustomPost::findOrFail($post_id);

            $post = $ttr->post('statuses/update', ['status' => $custom_post->text]);
            if(isset($post->id)) {
                $post_social_media=PostSocialMedia::where('custom_post_id',$post_id)->where('social_media_id',3)->first();
                $post_social_media->postId=$post->id;
                $post_social_media->status='sent';
                $post_social_media->save();
//                dd($post_social_media);
                return 'success';
            }else{
                return $post;
            }
        }catch (Exception $e){
            return $e->getMessage();
        }

    }

    // retrieve page data

    public static function getPosts( $access_token,$associate_token,$page_id)	{
        if ( !empty($access_token) )	{
            $twitter_config = Config::get('socialdata.twitter');
            $twitter = new TwitterOAuth($twitter_config['consumerKey'], $twitter_config['consumerSecret'], $access_token, $associate_token);
            return $twitter->get('statuses/user_timeline', ['screen_name'=>$page_id]);

        }
        return false;
    }
    public static function storeData($data,$company_social_account)
    {
        DB::beginTransaction();
        try {
            $i=1;
            foreach ($data as $id=>$item) {
                if($item->in_reply_to_status_id==null) {
                    $post = Post::where('post_id', $item->id)->where('sm_type_id',3)->first();
                    if (count($post) == 0) {
//                        dd($item->entities->media);
//                        dd($item->created_at);
                        $post = new Post();
                        $post->company_id = $company_social_account->company_id;
                        $post->sm_type_id = $company_social_account->sm_type_id;
                        $post->post = isset($item->text) ? $item->text : "";
                        $post->post_id = $item->id;
                        $post->post_date = $item->created_at;
//                    dd($post);
                        $post->save();
                        print "    Post Save \n";
//                    dd($item['attachments']);
//                    dd($item->extended_entities->media);
                        if (isset($item->extended_entities->media)) {
                            TwitterHelper::_attachments($post, $item->extended_entities->media);
                        }

                    }
                }else{
                    if(!Comment::where('comment_id',$item->id)->exists()) {
                        $post = Post::where('post_id', $item->in_reply_to_status_id)->where('sm_type_id', 3)->first();
                        $c = new Comment();
                        $c->post_id = $post->id;
                        $c->comment_id = $item->id;
                        $c->comment = isset($item->text) ? $item->text : "";
                        $c->comment_date = $item->created_at;
                        $c->save();
                        print "             Comment Save \n";
                    }
                }
            }
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollback();
            return $e->getMessage();
        }
    }
    private static function _attachments($post,$media)
    {
        foreach ($media as $item) {
            $post_image = new PostImage();
            $post_image->post_id = $post->id;
            $post_image->url_standard = $item->media_url;
            $post_image->save();
            print "     Post Attachment \n";
        }
    }

}