<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/1/16
 * Time: 1:06 PM
 */

namespace App\Helpers;


use App\CompanySocialAccount;
use App\CustomPost;
use Illuminate\Support\Facades\Config;
use Facebook\Facebook;


class SocialMediaHelper
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
    public static function publish_fb($id,$company_id)
    {
        $config= SocialMediaHelper::getFbConfig();
        $fb_account= CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id',2)->first();

        $fb= new Facebook($config);
        $fb->setDefaultAccessToken($fb_account->access_token);
        $pages=$fb->get('/me/accounts');
        $pages=$pages->getGraphEdge()->asArray();
        $page_access_token= null;
        $page_id= null;
        foreach ($pages as $page) {
            if($page['name']==$fb_account->page_id){
                $page_access_token=$page['access_token'];
                $page_id=$page['id'];
            }
        }
        if($page_access_token!=null && $page_access_token!=null)
        {
            try{
                $custom_post=CustomPost::findOrFail($id);
                $post=$fb->post('/'.$page_id.'/feed',['message'=>$custom_post->text],$page_access_token);
                $post=$post->getGraphNode()->asArray();
                if(isset($post['id']))
                {
                    $custom_post=CustomPost::findOrFail($id);
                    $custom_post->postId=$post['id'];
                    $custom_post->status='sent';
                    $custom_post->save();
                    return true;
                }
            }catch (Exception $e)
            {
                return $e;
            }
        }
        return false;
    }
}