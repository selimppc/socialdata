<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/5/16
 * Time: 12:11 PM
 */

namespace App\Helpers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\CompanySocialAccount;
use App\CustomPost;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;

class TwitterHelper
{
    public static function getTwitterConfig()
    {
        $twitter_config=Config::get('custom.twitter');
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
        $twitter_config=Config::get('custom.twitter');
        $config = [
            'consumer_key' => $twitter_config['consumerKey'],
            'consumer_secret' => $twitter_config['consumerSecret'],
            'oauth_access_token' => $twitter_config['outhToken'],
            'oauth_access_token_secret' => $twitter_config['othTokenSecret']
        ];
        return $config;
    }
    public static function getLoginUrl($user_social_account_id){
        $twitter_config=Config::get('custom.twitter');
        $callback=Config::get('custom.callback').'/twitter';
        $callback= url($callback);
        $ttr= new TwitterOAuth($twitter_config['consumerKey'],$twitter_config['consumerSecret']);
        $request_token= $ttr->oauth('oauth/request_token',['oauth_callback'=>$callback]);
        Session::put('oauth_token',$request_token['oauth_token']);
        Session::put('oauth_token_secret',$request_token['oauth_token_secret']);
        Session::put('user_social_account_id',$user_social_account_id);
        $loginUrl= $ttr->url('oauth/authorize',['oauth_token'=>$request_token['oauth_token']]);
        return $loginUrl;

    }
    public static function twitterReturn()
    {
        try {
            $twitter_config = Config::get('custom.twitter');
            $ttr = new TwitterOAuth($twitter_config['consumerKey'], $twitter_config['consumerSecret'], session('oauth_token'), session('oauth_token_secret'));
            $access_token = $ttr->oauth('oauth/access_token', ['oauth_verifier' => $_REQUEST['oauth_verifier']]);
            return $access_token;
        }catch (Exception $e){
            return $e->getMessage();
        }


    }
    public static function publish($post_id){
        try {
            $twitter_config = Config::get('custom.twitter');
            $ttr_account = CompanySocialAccount::where('company_id', session('companyId'))->where('sm_type_id', 3)->first();
            $ttr = new TwitterOAuth($twitter_config['consumerKey'], $twitter_config['consumerSecret'], $ttr_account->access_token, $ttr_account->associate_token);
            $custom_post=CustomPost::findOrFail($post_id);

            $post = $ttr->post('statuses/update', ['status' => $custom_post->text]);
            if(isset($post->id)) {
                $custom_post->postId = $post->id;
                $custom_post->status = 'sent';
                $custom_post->save();
                return true;
            }else{
                return $post;
            }
        }catch (Exception $e){
            return $e->getMessage();
        }

    }

}