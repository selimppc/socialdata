<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/31/16
 * Time: 3:00 PM
 */

namespace App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class SMConfigController extends Controller
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

}