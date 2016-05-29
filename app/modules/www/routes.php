<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 12:45 PM
 */
Route::group(['prefix'=>'www','modules'=>'www','namespace'=>'App\Modules\Www\Controllers'],function(){
    Route::get('add-social-media', [
        #'middleware' => 'acl_access:user-list',
        'as' => 'add-social-media',
        'uses' => 'SocialMediaController@index'
    ]);
    Route::get('social-media-return/{social_media_type}/{company_social_media_id}', [
        #'middleware' => 'acl_access:user-list',
        'as' => 'social-media-return',
        'uses' => 'SocialMediaController@social_media_return'
    ]);
    Route::get('get-posts/{user_social_media_id}', [
        #'middleware' => 'acl_access:user-list',
        'as' => 'get-posts',
        'uses' => 'SocialMediaController@get_posts'
    ]);
});