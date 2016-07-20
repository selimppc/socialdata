<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/7/16
 * Time: 10:23 AM
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Mockery\CountValidator\Exception;

class GooglePlusHelper
{
    public Static function client(){
        $config=Config::get('custom.google');
        $config['redirect_uri']= url(Config::get('custom.callback').'/google');
        $config['access_type']= 'offline';
        $client = new \Google_Client($config);
        return $client;
    }
    public static function plus($client)
    {
        return new \Google_Service_Plus($client);
    }
    public static function getLoginUrl()
    {
        $client= GooglePlusHelper::client();
        $scope=[
            'email',
            'profile'
        ];
        $loginUrl=$client->createAuthUrl($scope);
        return $loginUrl;
    }
    public static function _return(){
        try{
            $client= GooglePlusHelper::client();
            $client->authenticate($_REQUEST['code']);
            $data['refresh_token']=$client->getRefreshToken();
            $client->setAccessToken($client->getAccessToken());
            $plus= GooglePlusHelper::plus($client);
            $user=$plus->people->get('me');
            $data['user_id']=$user['id'];
            return $data;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}