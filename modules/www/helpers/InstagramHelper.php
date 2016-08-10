<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 8/9/16
 * Time: 11:03 AM
 */

namespace App\Helpers;


use App\Post;
use App\PostImage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class InstagramHelper
{
    public static function getIgConfig()
    {
        @session_start();
        $ig_config=Config::get('custom.instagram');
        $config = [
            'client_id' => $ig_config['client_id'],
            'client_secret' => $ig_config['client_secret'],
        ];
        return $config;
    }
    public static function getLoginUrl()
    {
        $config = InstagramHelper::getIgConfig();
        $redirect_url=url('www/social-media-return/instagram');
        $url='https://api.instagram.com/oauth/authorize/?client_id='.$config["client_id"].'&redirect_uri='.$redirect_url.'&response_type=code&scope=basic+public_content';
        return $url;
    }
    public static function getAccessToken( $code=false )	{
        if ( !empty($code) )	{
            $config = InstagramHelper::getIgConfig();
            $redirect_url=url('www/social-media-return/instagram');
            $access_token_url='https://api.instagram.com/oauth/access_token';

            $curl = curl_init();
            curl_setopt_array( $curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $access_token_url,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => array(
                    'client_id' => $config["client_id"],
                    'client_secret' => $config["client_secret"],
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirect_url,
                    'code' => $code
                )
            ));

            $data = array();

            if ( $output = curl_exec( $curl ) )	{
                $output = json_decode( $output );
                $data = array(
                    'user_id' => $output->user->id,
                    'username' => $output->user->username,
                    'name' => $output->user->full_name,
                    'avatar' => $output->user->profile_picture,
                    'access_token' => $output->access_token
                );
//                $this->__set( 'access_token', $data['access_token'] );
            }
            curl_close( $curl );
            return $data;
        }
        return false;
    }
    public static function getData( $access_token)	{
        if ( !empty($access_token) )	{
            $config = InstagramHelper::getIgConfig();
//            $redirect_url=url('www/social-media-return/instagram');
//            $pull_url='https://api.instagram.com/v1/tags/nofilter/media/recent?access_token='.$access_token;
            $pull_url='https://api.instagram.com/v1/users/self/media/liked?access_token='.$access_token;
//            dd($pull_url);
            $curl = curl_init();
            curl_setopt_array( $curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $pull_url
            ));

            $data = array();

            if ( $output = curl_exec( $curl ) )	{
                $data = json_decode( $output );
            }
            curl_close( $curl );
            return $data;
        }
        return false;
    }
    public static function storeData($data,$company_social_account)
    {
        DB::beginTransaction();
        try {
            foreach ($data->data as $item) {
                $post = new Post();
                $post->company_id = $company_social_account->company_id;
                $post->sm_type_id = $company_social_account->sm_type_id;
                if (isset($item->caption->text)) {
                    $post->post = $item->caption->text;
                }
                $post->post_id = $item->caption->id;
                $post->save();
                $post_image= new PostImage();
                $post_image->post_id=$post->id;
                $post_image->url_thumbnail=$item->images->thumbnail->url;
                $post_image->url_low=$item->images->low_resolution->url;
                $post_image->url_standard=$item->images->standard_resolution->url;
                $post_image->save();
            }
            DB::commit();
        }catch (Exception $e)
        {
            DB::rollback();
            return $e->getMessage();
        }
    }
}