<?php

namespace Modules\Socialdata\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TwitterApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = array(
            'oauth_access_token' => "707118658229698560-GxOU9hq56QFEzVpHR4HHL7h3MnHyKgJ",
            'oauth_access_token_secret' => "UxRtbw8qCzkaqsfInbzlttJw80j8IMIJWSM0saP9y629e",
            'consumer_key' => "dg38tfZt8l6VwlILLivRoAoEK",
            'consumer_secret' => "chlkofsQctIVJeOUB1fm5ROOFUnQ7HtqfA9iGN0jZl0lQ4XHvz"
        );
        $twitter = new \TwitterAPIExchange($settings);
        //$url = 'https://api.twitter.com/1.1/followers/ids.json';
        //$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        //$getfield = '?screen_name=bankofamerica&count=1';
        $requestMethod = 'GET';

        #$twitter = new TwitterAPIExchange($settings);

        $all_tweets = array();
        $max_tweets_per_response = 100;
        $last_tweet_id = '704423448802512896';
        $max_tweets_you_want_to_obtain = 666;
        $getfield = "?screen_name=bankofamerica&count=$max_tweets_per_response";

        $posts = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
        $tweetarray = json_decode($posts);
        foreach ($tweetarray as $item) {
            $since_id = $item->id;
        }
        echo $since_id;
        $getfield = "?screen_name=bankofamerica&count=$max_tweets_per_response&since_id=$since_id";

        $posts1 = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
        print_r($posts1);exit;
        print_r($tweetarray);exit;

        try{
            $all_tweets = array_merge($all_tweets, $tweetarray);
        }catch(\Exception $e){
            echo $e->getMessage();
        }
        exit('accha');
        #count=$max_tweets_per_response & since_id=$last_tweet_id
        while(count($tweetarray) < $max_tweets_per_response || count($all_tweets) >= $max_tweets_you_want_to_obtain){
            $getfield = "?screen_name=bankofamerica&count=$max_tweets_per_response&since_id=$last_tweet_id";
            $posts = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
            $tweetarray = json_decode($posts);
            $all_tweets = array_merge($all_tweets, $tweetarray);
        }
        echo 'total values->>>>>>>>>'.count($all_tweets);
        exit;
        foreach ($posts as $post) {
            /*echo $post->id."<br>";
            echo $post->text."<br>";
            $old_date_timestamp1 = strtotime($post->created_at);
            $new_date1 = date('Y-m-d H:i:s', $old_date_timestamp1);
            echo $new_date1."<br>";*/
        }
        //print_r($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
