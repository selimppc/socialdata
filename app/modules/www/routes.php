<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 12:45 PM
 */
Route::group(['prefix'=>'www','modules'=>'www','namespace'=>'App\Modules\Www\Controllers'],function(){
    Route::get('add-social-media', [
        #'middleware' => 'acl_access:add-social-media',
        'as' => 'add-social-media',
        'uses' => 'SocialMediaController@index'
    ]);
    Route::get('social-media-return/{social_media_type}/{company_social_media_id}', [
        #'middleware' => 'acl_access:social-media-return',
        'as' => 'social-media-return',
        'uses' => 'SocialMediaController@social_media_return'
    ]);
    Route::get('get-posts/{user_social_media_id}', [
        #'middleware' => 'acl_access:get-posts',
        'as' => 'get-posts',
        'uses' => 'SocialMediaController@get_posts'
    ]);
    Route::get('select-company', [
        #'middleware' => 'acl_access:select-company',
        'as' => 'select-company',
        'uses' => 'SettingController@select_company'
    ]);
    Route::post('select-company', [
        #'middleware' => 'acl_access:select-company',
        'as' => 'select-company',
        'uses' => 'SettingController@store_company'
    ]);
    Route::get('posts',[
        #'middleware' => 'acl_access:posts',
        'as'=> 'posts',
        'uses' => 'CustomPostController@index'
    ]);
    Route::post('store-post',[
        #'middleware' => 'acl_access:store-post',
        'as'=> 'store-post',
        'uses' => 'CustomPostController@store'
    ]);
    Route::get('edit-post/{id}',[
        #'middleware' => 'acl_access:edit-post',
        'as'=> 'edit-post',
        'uses' => 'CustomPostController@edit'
    ]);
    Route::patch('update-post/{id}',[
        #'middleware' => 'acl_access:update-post',
        'as'=> 'update-post',
        'uses' => 'CustomPostController@update'
    ]);
});