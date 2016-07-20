<?php
/**
 * Created by PhpStorm.
 * User: sr
 * Date: 3/2/16
 * Time: 4:11 PM
 */



Route::any('user-activity', [
    'middleware' => 'acl_access:user-activity',
    'as' => 'user-activity',
    'uses' => 'UserActivityController@index'
]);


Route::get('search-user-activity', [
    'middleware' => 'acl_access:user-activity',
    'as' => 'search-user-activity',
    'uses' => 'UserActivityController@search_user_activity'
]);