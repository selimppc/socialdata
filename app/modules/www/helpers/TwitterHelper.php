<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 6/5/16
 * Time: 12:11 PM
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

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

}