<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/7/16
 * Time: 10:23 AM
 */

namespace App\Helpers;

use App\Comment;
use App\CompanySocialAccount;
use App\Console\Commands\GooglePlus;
use App\Post;
use App\PostImage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class GooglePlusHelper
{
    public Static function client(){
        $config=Config::get('socialdata.google');
        $config['redirect_uri']= url(Config::get('settingData.callback').'/google');
        $config['access_type']= 'offline';
        $client = new \Google_Client($config);
        return $client;
    }
    public static function plus($refresh_token)
    {
        $client= GooglePlusHelper::client();
        $client->refreshToken($refresh_token);
        return new \Google_Service_Plus($client);
    }
    public static function getLoginUrl()
    {
        $client= GooglePlusHelper::client();
        $client->setScopes('https://www.googleapis.com/auth/plus.profile.emails.read');
        $loginUrl=$client->createAuthUrl();
        return $loginUrl;
    }
    public static function _return(){
        try{
            $client= GooglePlusHelper::client();
            $client->authenticate($_REQUEST['code']);
            $data['refresh_token']=$client->getRefreshToken();
            $client->setAccessToken($client->getAccessToken());
            $plus= new \Google_Service_Plus($client);
            $user=$plus->people->get('me');
            $data['user_id']=$user['id'];
            return $data;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    // retrieve page data

    public static function getPosts( $access_token,$page_id)	{
        if ( !empty($access_token) )	{
            $plus= GooglePlusHelper::plus($access_token);
            return $plus->activities->listActivities($page_id, 'public');
        }
        return false;
    }
    public static function storeData($data,$company_social_account)
    {
//        DB::beginTransaction();
        try {
            foreach ($data as $id=>$item) {
                $post=Post::where('post_id',$item->id)->where('sm_type_id',1)->first();
                if(count($post) == 0) {
                    $post = new Post();
                    $post->company_id = $company_social_account->company_id;
                    $post->sm_type_id = $company_social_account->sm_type_id;
                    $post->post = isset($item->object['content'])?$item->object['content']:"";
                    $post->post_id = $item->id;
                    $post->post_date = $item->published;
//                    dd($post);
                    $post->save();
                    print "    Post Save \n";
//                    dd($item['attachments']);
//                    dd($item);
                    if(isset($item->object['attachments'])) {
                        GooglePlusHelper::_attachments($post,$item);
                    }

                }
                // store comment
                if($item->object->replies->totalItems>=1)
                {
                    $comments=GooglePlusHelper::_getComments($post->id);
                    GooglePlusHelper::_storeComments($post->id,$comments);
                }
            }
//            DB::commit();
        }catch (Exception $e)
        {
//            DB::rollback();
            return $e->getMessage();
        }
    }
    private static function _attachments($post,$item)
    {
        foreach ($item->object['attachments'] as $id=>$attachment) {
            if(isset($attachment['thumbnails']))
            {
                foreach ($attachment['thumbnails'] as $id=>$thumbnail) {
                    $post_image = new PostImage();
                    $post_image->post_id = $post->id;
                    $post_image->description = isset($thumbnail->description)?$thumbnail->description:'';
                    $post_image->url_standard = $thumbnail->image['url'];
                    $post_image->save();
                    print "         Image Save \n";
                }
            }else {
                $post_image = new PostImage();
                $post_image->post_id = $post->id;
                $post_image->description = isset($attachment->description)?$attachment->description:'';
                $post_image->url_standard = $attachment->image['url'];
                $post_image->save();
                print "         Image Save \n";
            }
        }
    }

    private static function _getComments($post_id)
    {
        $post= Post::findOrFail($post_id);
        $company_social_account= CompanySocialAccount::where('company_id',$post->company_id)->where('sm_type_id',1)->first();
        $plus= GooglePlusHelper::plus($company_social_account->access_token);
        return $plus->comments->listComments($post->post_id);
    }
    private static function _storeComments($post_id,$comments)
    {
        foreach ($comments as $comment) {
            if(!Comment::where('comment_id',$comment['id'])->exists()) {
                $c = new Comment();
                $c->post_id = $post_id;
                $c->comment_id = $comment['id'];
                $c->comment = $comment['object']->content;
                $c->comment_date = $comment['published'];
                $c->save();
                print "             Comment Save \n";
            }
        }
    }
}