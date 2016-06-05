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
        #'middleware' => 'acl_access:social-media-return/{social_media_type}/{company_social_media_id}',
        'as' => 'social-media-return',
        'uses' => 'SocialMediaController@social_media_return'
    ]);
    Route::get('get-posts/{user_social_media_id}', [
        #'middleware' => 'acl_access:get-posts/{user_social_media_id}',
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
        #'middleware' => 'acl_access:edit-post/{id}',
        'as'=> 'edit-post',
        'uses' => 'CustomPostController@edit'
    ]);
    Route::patch('update-post/{id}',[
        #'middleware' => 'acl_access:update-post/{id}',
        'as'=> 'update-post',
        'uses' => 'CustomPostController@update'
    ]);
    Route::get('publish-fb/{id}',[
        #'middleware' => 'acl_access:publish-fb/{id}',
        'as'=> 'publish-fb',
        'uses' => 'CustomPostController@publish_fb'
    ]);
    Route::get('create-schedule/{post_id}',[
        #'middleware' => 'acl_access:create-schedule/{post_id}',
        'as'=> 'create-schedule',
        'uses' => 'CustomPostController@create_schedule'
    ]);
    Route::post('create-schedule/{post_id}',[
        #'middleware' => 'acl_access:create-schedule/{post_id}',
        'as'=> 'create-schedule',
        'uses' => 'CustomPostController@store_schedule'
    ]);
    Route::get('edit-schedule/{schedule_id}',[
        #'middleware' => 'acl_access:edit-schedule/{schedule_id}',
        'as'=> 'edit-schedule',
        'uses' => 'CustomPostController@edit_schedule'
    ]);
    Route::get('show-schedule/{schedule_id}',[
        #'middleware' => 'acl_access:show-schedule/{schedule_id}',
        'as'=> 'show-schedule',
        'uses' => 'CustomPostController@show_schedule'
    ]);
    Route::post('update-schedule/{schedule_id}',[
        #'middleware' => 'acl_access:update-schedule/{schedule_id}',
        'as'=> 'update-schedule',
        'uses' => 'CustomPostController@update_schedule'
    ]);


    /*
     * User Request for join start
     * */

    Route::get('request', [
        #'middleware' => 'acl_access:request',
        'as' => 'request',
        'uses' => 'UserRegistrationController@create'
    ]);

    Route::post('request', [
        #'middleware' => 'acl_access:request',
        'as' => 'request',
        'uses' => 'UserRegistrationController@store'
    ]);


    Route::get('user-confirmation/{remember_token}',[
        'middleware'=> 'acl_access:user-confirmation/{remember_token}',
        'as'=>'user-confirmation',
        'uses'=>'UserRegistrationController@user_confirm']);

    Route::post('user-confirmation', [
        'middleware'=> 'acl_access:user-confirmation',
        'as' => 'user-confirmation',
        'uses' => 'UserRegistrationController@update'
    ]);

    Route::get('user-activation/{remember_token}',[
        'middleware'=> 'acl_access:user-activation/{remember_token}',
        'as'=>'user-activation',
        'uses'=>'UserRegistrationController@user_activation'
    ]);

    /*
     * User Request for join end
     * */

});