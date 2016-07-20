<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 1/14/16
 * Time: 3:59 PM
 */

Route::group(array('middleware' => 'auth','modules'=>'Api_app', 'namespace' => 'Modules\Api_app\Controllers'), function() {
    //Your routes belong to this module.

    //api app route

    Route::any('api_app', [
        'as' => 'api_app',
        'uses' => 'ApiController@index'
    ]);

});

