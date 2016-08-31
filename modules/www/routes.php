<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 12:45 PM
 */
Route::group(['middleware' => 'auth', 'prefix'=>'www','modules'=>'www','namespace'=>'Modules\Www\Controllers'],function(){
    Route::get('add-social-media', [
        'middleware' => 'acl_access:www/add-social-media',
        'as' => 'add-social-media',
        'uses' => 'SocialMediaController@index'
    ]);
    Route::any('social-media-return/{social_media_type}', [
        'middleware' => 'acl_access:www/social-media-return/{social_media_type}',
        'as' => 'social-media-return',
        'uses' => 'SocialMediaController@social_media_return'
    ]);
    Route::get('get-posts/{user_social_media_id}', [
        'middleware' => 'acl_access:www/get-posts/{user_social_media_id}',
        'as' => 'get-posts',
        'uses' => 'SocialMediaController@get_posts'
    ]);
    Route::get('select-company', [
        'middleware' => 'acl_access:www/select-company',
        'as' => 'select-company',
        'uses' => 'SettingController@select_company'
    ]);
    Route::post('select-company', [
        'middleware' => 'acl_access:www/select-company',
        'as' => 'select-company',
        'uses' => 'SettingController@store_company'
    ]);
    Route::get('posts',[
        'middleware' => 'acl_access:www/posts',
        'as'=> 'posts',
        'uses' => 'CustomPostController@index'
    ]);
    Route::get('add-post',[
        'middleware' => 'acl_access:www/add-post',
        'as'=> 'add-post',
        'uses' => 'CustomPostController@create'
    ]);
    Route::post('store-post',[
        'middleware' => 'acl_access:www/store-post',
        'as'=> 'store-post',
        'uses' => 'CustomPostController@store'
    ]);
    Route::get('edit-post/{id}',[
        'middleware' => 'acl_access:www/edit-post/{id}',
        'as'=> 'edit-post',
        'uses' => 'CustomPostController@edit'
    ]);
    Route::patch('update-post/{id}',[
        'middleware' => 'acl_access:www/update-post/{id}',
        'as'=> 'update-post',
        'uses' => 'CustomPostController@update'
    ]);
    Route::get('publish/{id}',[
        'middleware' => 'acl_access:www/publish-fb/{id}',
        'as'=> 'publish-fb',
        'uses' => 'CustomPostController@publish'
    ]);
    Route::get('create-schedule',[
        'middleware' => 'acl_access:www/create-schedule/{post_id}',
        'as'=> 'create-schedule',
        'uses' => 'CustomPostController@create_schedule'
    ]);
    Route::post('create-schedule/{post_id}',[
        'middleware' => 'acl_access:www/create-schedule/{post_id}',
        'as'=> 'create-schedule',
        'uses' => 'CustomPostController@store_schedule'
    ]);
    Route::get('edit-schedule/{schedule_id}',[
        'middleware' => 'acl_access:www/edit-schedule/{schedule_id}',
        'as'=> 'edit-schedule',
        'uses' => 'CustomPostController@edit_schedule'
    ]);
    Route::get('show-schedule/{schedule_id}',[
        'middleware' => 'acl_access:www/show-schedule/{schedule_id}',
        'as'=> 'show-schedule',
        'uses' => 'CustomPostController@show_schedule'
    ]);
    Route::post('update-schedule/{schedule_id}',[
        'middleware' => 'acl_access:www/update-schedule/{schedule_id}',
        'as'=> 'update-schedule',
        'uses' => 'CustomPostController@update_schedule'
    ]);


    /*
     * User Request for join start
     * */

    Route::get('request', [
        'middleware' => 'acl_access:www/request',
        'as' => 'request',
        'uses' => 'UserRegistrationController@create'
    ]);

    Route::post('request', [
        'middleware' => 'acl_access:www/request',
        'as' => 'request',
        'uses' => 'UserRegistrationController@store'
    ]);


    Route::get('user-confirmation/{remember_token}',[
        'middleware'=> 'acl_access:www/user-confirmation/{remember_token}',
        'as'=>'user-confirmation',
        'uses'=>'UserRegistrationController@user_confirm']);

    Route::post('user-confirmation', [
        'middleware'=> 'acl_access:www/user-confirmation',
        'as' => 'user-confirmation',
        'uses' => 'UserRegistrationController@update'
    ]);

    Route::get('user-activation/{remember_token}',[
        'middleware'=> 'acl_access:www/user-activation/{remember_token}',
        'as'=>'user-activation',
        'uses'=>'UserRegistrationController@user_activation'
    ]);

    /*
     * User Request for join end
     * */

    // search route
    Route::get('search',[
        'middleware'=>'acl_access:www/search',
        'as'=>'main-search',
        'uses'=>'SettingController@main_search'
    ]);

    // News Feeds Routes
    Route::get('feeds/instagram/{post_id}',[
        'middleware'=>'acl_access:www/feeds/instagram/{post_id}',
        'as' => 'feeds/instagram/{post_id}',
        'uses'=>'FeedController@details'
    ]);
    Route::get('feeds/instagram',[
        'middleware'=>'acl_access:www/feeds/instagram',
        'as' => 'feeds/instagram',
        'uses'=>'FeedController@feeds'
    ]);
    Route::get('feeds/twitter/{post_id}',[
        'middleware'=>'acl_access:www/feeds/twitter/{post_id}',
        'as' => 'feeds/twitter/{post_id}',
        'uses'=>'FeedController@details'
    ]);
    Route::get('feeds/twitter',[
        'middleware'=>'acl_access:www/feeds/twitter',
        'as' => 'feeds/twitter',
        'uses'=>'FeedController@feeds'
    ]);
    Route::get('feeds/facebook/{post_id}',[
        'middleware'=>'acl_access:www/feeds/facebook/{post_id}',
        'as' => 'feeds/facebook/{post_id}',
        'uses'=>'FeedController@details'
    ]);
    Route::get('feeds/facebook',[
        'middleware'=>'acl_access:www/feeds/facebook',
        'as' => 'feeds/facebook',
        'uses'=>'FeedController@feeds'
    ]);
    Route::get('feeds/googleplus/{post_id}',[
        'middleware'=>'acl_access:www/feeds/googleplus/{post_id}',
        'as' => 'feeds/googleplus/{post_id}',
        'uses'=>'FeedController@details'
    ]);
    Route::get('feeds/googleplus',[
        'middleware'=>'acl_access:www/feeds/googleplus',
        'as' => 'feeds/googleplus',
        'uses'=>'FeedController@feeds'
    ]);
    Route::get('analytics/facebook/settings',[
        'middleware'=>'acl_access:www/analytics/facebook/settings',
        'as' => 'analytics/facebook/settings',
        'uses'=>'CompanyMetricsController@analytics_settings'
    ]);
    Route::post('analytics/facebook/settings',[
        'middleware'=>'acl_access:www/analytics/facebook/settings',
        'as' => 'company_metrics.store',
        'uses'=>'CompanyMetricsController@store'
    ]);
    Route::get('analytics/facebook',[
        'middleware'=>'acl_access:www/analytics/facebook',
        'as' => 'company_metrics.facebook',
        'uses'=>'AnalyticsController@index'
    ]);

    Route::get('get_analytics',[
//        'middleware'=>'acl_access:www/feeds/googleplus',
        'as' => 'get_analytics',
        'uses'=>'AnalyticsController@get_analytics'
    ]);
});