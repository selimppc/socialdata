<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/31/16
 * Time: 12:55 PM
 */

return [
        'facebook'=>[
                'app_id'=>'251889945201960',
                'app_secret'=>'38db4d9210cbffda07f78baf35eaf981'
        ],
        'post_status'=>['new','inactive','cancel','delete','ready','processing','sent'],
        'twitter'=>[
                'consumerKey'=>'dg38tfZt8l6VwlILLivRoAoEK',
                'consumerSecret'=>'chlkofsQctIVJeOUB1fm5ROOFUnQ7HtqfA9iGN0jZl0lQ4XHvz',
                'outhToken' => '707118658229698560-GxOU9hq56QFEzVpHR4HHL7h3MnHyKgJ',
                'othTokenSecret'=> 'UxRtbw8qCzkaqsfInbzlttJw80j8IMIJWSM0saP9y629e'
        ],
        'permissions' => [
                'public_profile',
                'user_friends',
                'email',
                'user_about_me',
                'user_actions.books',
                'user_actions.fitness',
                'user_actions.music',
                'user_actions.news',
                'user_actions.video',
            //user_actions:{app_namespace}
                'user_birthday',
                'user_education_history',
                'user_events',
                'user_games_activity',
                'user_hometown',
                'user_likes',
                'user_location',
                'user_managed_groups',
                'user_photos',
                'user_posts',
                'user_relationships',
                'user_relationship_details',
                'user_religion_politics',
                'user_tagged_places',
                'user_videos',
                'user_website',
                'user_work_history',
                'read_custom_friendlists',
                'read_insights',
                'read_audience_network_insights',
                'read_page_mailboxes',
                'manage_pages',
                'publish_pages',
                'publish_actions',
                'rsvp_event',
                'pages_show_list',
                'pages_manage_cta',
                'pages_manage_instant_articles',
                'ads_read',
                'ads_management',
                'pages_messaging',
                'pages_messaging_phone_number'
        ]
];