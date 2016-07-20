<?php

Route::group(['modules' => 'Socialdata', 'namespace' => 'Modules\Socialdata\Controllers'], function() {
    Route::get('/api/v1/posts/{company_id?}/{sm_type_id?}', [
        'middleware' => 'api_check',
        'as' => 'api-v1-posts',
        'uses' => 'PostController@api_post'
    ]);

    Route::any('/api/v1/posts_search/{company_id?}/{sm_type_id?}/{text?}', [
        'middleware' => 'api_check',
        'as' => 'api-v1-posts',
        'uses' => 'PostController@api_post_search'
    ]);

});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'auth', 'modules' => 'Socialdata', 'namespace' => 'Modules\Socialdata\Controllers'], function() {

    /*Route::any('dashboard', [
        "as" => 'dashboard',
        "uses" => "UserController@index"
    ]);*/
    //google api routes
    Route::any('google-api-index', [
        //"middleware" => "acl_access:google-api-index",
        'as' => 'google-api-index',
        'uses' => 'GoogleApiController@index'
    ]);

    Route::any('google-api-view', [
        //"middleware" => "acl_access:google-api-view",
        'as' => 'google-api-view',
        'uses' => 'GoogleApiController@view'
    ]);

    Route::any('google-plus-info', [
        //"middleware" => "acl_access:google-plus-info",
        'as' => 'google-plus-info',
        'uses' => 'GoogleApiController@google_plus_info'
    ]);


    //facebook api routes
    Route::any('facebook-api-index', [
        //"middleware" => "acl_access:facebook-api-index",
        'as' => 'facebook-api-index',
        'uses' => 'FacebookApiController@index'
    ]);

    //twitter api routes
    Route::any('twitter-api-index', [
        //"middleware" => "acl_access:twitter-api-index",
        'as' => 'twitter-api-index',
        'uses' => 'TwitterApiController@index'
    ]);

    //export post routes
    Route::any('export-post-index', [
        //"middleware" => "acl_access:export-post-index",
        'as' => 'export-post-index',
        'uses' => 'PostController@export_post_index'
    ]);

    Route::any('export-post-csv', [
        //"middleware" => "acl_access:export-post-index",
        'as' => 'export-post-csv',
        'uses' => 'PostController@export_post_csv'
    ]);

    //Company Controller

    Route::any("index-company", [
        //"middleware" => "acl_access:index-company",
        "as"   => "index-company",
        "uses" => "CompanyController@index"
    ]);

    Route::any("store-company", [
        //"middleware" => "acl_access:store-company",
        "as"   => "store-company",
        "uses" => "CompanyController@store"
    ]);

    Route::any("view-company/{id}", [
        //"middleware" => "acl_access:view-company/{id}",
        "as"   => "view-company",
        "uses" => "CompanyController@show"
    ]);

    Route::any("edit-company/{id}", [
        //"middleware" => "acl_access:edit-company/{id}",
        "as"   => "edit-company",
        "uses" => "CompanyController@edit"
    ]);

    Route::any("update-company/{id}", [
        //"middleware" => "acl_access:update-company/{id}",
        "as"   => "update-company",
        "uses" => "CompanyController@update"
    ]);

    Route::any("delete-company/{id}", [
        //"middleware" => "acl_access:delete-company/{id}",
        "as"   => "delete-company",
        "uses" => "CompanyController@delete"
    ]);

    //SmType Controller

    Route::any("index-sm-type", [
        //"middleware" => "acl_access:index-sm-type",
        "as"   => "index-sm-type",
        "uses" => "SmTypeController@index"
    ]);

    Route::any("store-sm-type", [
        //"middleware" => "acl_access:store-sm-type",
        "as"   => "store-sm-type",
        "uses" => "SmTypeController@store"
    ]);

    Route::any("view-sm-type/{id}", [
        //"middleware" => "acl_access:view-sm-type/{id}",
        "as"   => "view-sm-type",
        "uses" => "SmTypeController@show"
    ]);

    Route::any("edit-sm-type/{id}", [
        //"middleware" => "acl_access:edit-sm-type/{id}",
        "as"   => "edit-sm-type",
        "uses" => "SmTypeController@edit"
    ]);

    Route::any("update-sm-type/{id}", [
        //"middleware" => "acl_access:update-sm-type/{id}",
        "as"   => "update-sm-type",
        "uses" => "SmTypeController@update"
    ]);

    Route::any("delete-sm-type/{id}", [
        //"middleware" => "acl_access:delete-sm-type/{id}",
        "as"   => "delete-sm-type",
        "uses" => "SmTypeController@delete"
    ]);

    //Company social account Controller

    Route::any("index-company-social-account/{company_id}", [
        //"middleware" => "acl_access:index-company-social-account",
        "as"   => "index-company-social-account",
        "uses" => "CompanySocialAccountController@index"
    ]);

    Route::any("store-company-social-account", [
        //"middleware" => "acl_access:store-company-social-account",
        "as"   => "store-company-social-account",
        "uses" => "CompanySocialAccountController@store"
    ]);

    Route::any("view-company-social-account/{id}", [
        //"middleware" => "acl_access:view-company-social-account/{id}",
        "as"   => "view-company-social-account",
        "uses" => "CompanySocialAccountController@show"
    ]);

    Route::any("edit-company-social-account/{id}", [
        //"middleware" => "acl_access:edit-company-social-account/{id}",
        "as"   => "edit-company-social-account",
        "uses" => "CompanySocialAccountController@edit"
    ]);

    Route::any("update-company-social-account/{id}", [
        //"middleware" => "acl_access:update-company-social-account/{id}",
        "as"   => "update-company-social-account",
        "uses" => "CompanySocialAccountController@update"
    ]);

    Route::any("delete-company-social-account/{id}", [
        //"middleware" => "acl_access:delete-company-social-account/{id}",
        "as"   => "delete-company-social-account",
        "uses" => "CompanySocialAccountController@delete"
    ]);

    //Post Controller

    Route::any("index-post", [
        //"middleware" => "acl_access:index-post",
        "as"   => "index-post",
        "uses" => "PostController@index"
    ]);

    Route::any("store-post", [
        //"middleware" => "acl_access:store-post",
        "as"   => "store-post",
        "uses" => "PostController@store"
    ]);

    Route::any("view-post/{id}", [
        //"middleware" => "acl_access:view-post/{id}",
        "as"   => "view-post",
        "uses" => "PostController@show"
    ]);

    Route::any("edit-post/{id}", [
        //"middleware" => "acl_access:edit-post/{id}",
        "as"   => "edit-post",
        "uses" => "PostController@edit"
    ]);

    Route::any("update-post/{id}", [
        //"middleware" => "acl_access:update-post/{id}",
        "as"   => "update-post",
        "uses" => "PostController@update"
    ]);

    Route::any("delete-post/{id}", [
        //"middleware" => "acl_access:delete-post/{id}",
        "as"   => "delete-post",
        "uses" => "PostController@delete"
    ]);

    Route::any('search-post', [
        //'middleware' => 'acl_access:search-permission-role',
        'as' => 'search-post',
        'uses' => 'PostController@search_post'
    ]);

    //Comment Controller
    Route::any("index-comment/{post_id}", [
        //"middleware" => "acl_access:index-comment/{post_id}",
        "as"   => "index-comment",
        "uses" => "CommentController@index"
    ]);

    Route::any("view-comment/{id}", [
        //"middleware" => "acl_access:view-comment/{id}",
        "as"   => "view-comment",
        "uses" => "CommentController@show"
    ]);

    Route::any("edit-comment/{id}", [
        //"middleware" => "acl_access:edit-comment/{id}",
        "as"   => "edit-comment",
        "uses" => "CommentController@edit"
    ]);

    Route::any("update-comment/{id}", [
        //"middleware" => "acl_access:update-comment/{id}",
        "as"   => "update-comment",
        "uses" => "CommentController@update"
    ]);

    Route::any("delete-comment/{id}", [
        //"middleware" => "acl_access:delete-comment/{id}",
        "as"   => "delete-comment",
        "uses" => "CommentController@delete"
    ]);

    Route::any('search-comment', [
        //'middleware' => 'acl_access:search-comment',
        'as' => 'search-comment',
        'uses' => 'CommentController@search_comment'
    ]);

    Route::any('delete-comment-post', [
        'as' => 'delete-comment-post',
        'uses' => 'CommentController@delete_comment_post'
    ]);
});