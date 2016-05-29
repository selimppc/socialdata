<?php

namespace App\Console\Commands;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Company;
use App\CompanySocialAccount;
use App\Post;
use App\SmType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Twitter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:twitter {user_id=1}{company_id=0}{sm_type_id=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get twitter post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function twitter_auth(){
        $consumerKey = 'dg38tfZt8l6VwlILLivRoAoEK';
        $consumerSecret = 'chlkofsQctIVJeOUB1fm5ROOFUnQ7HtqfA9iGN0jZl0lQ4XHvz';
        $outhToken = '707118658229698560-GxOU9hq56QFEzVpHR4HHL7h3MnHyKgJ';
        $othTokenSecret = 'UxRtbw8qCzkaqsfInbzlttJw80j8IMIJWSM0saP9y629e';

        $twitter = new TwitterOAuth($consumerKey, $consumerSecret, $outhToken, $othTokenSecret);
        return $twitter;
    }
    private static $i=0;
    public function handle()
    {
        $settings = array(
            'oauth_access_token' => "707118658229698560-GxOU9hq56QFEzVpHR4HHL7h3MnHyKgJ",
            'oauth_access_token_secret' => "UxRtbw8qCzkaqsfInbzlttJw80j8IMIJWSM0saP9y629e",
            'consumer_key' => "dg38tfZt8l6VwlILLivRoAoEK",
            'consumer_secret' => "chlkofsQctIVJeOUB1fm5ROOFUnQ7HtqfA9iGN0jZl0lQ4XHvz"
        );
        $twitter = new \TwitterAPIExchange($settings);
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $requestMethod = 'GET';
        $twitter_conf = [
            'twitter' => $twitter,
            'url' => $url,
            'requestMethod' => $requestMethod
        ];
        $company_id = $this->argument('company_id');
        $sm_type_id = $this->argument('sm_type_id');
        $sm_type_specific = 'twitter';
        //for all company Twitter
        if($company_id == 0){
            if(SmType::where('type', $sm_type_specific)->where('status','active')->exists()){
                $sm_type_details = SmType::where('type', $sm_type_specific)->where('status','active')->first();
                if(CompanySocialAccount::where('status','active')->where('sm_type_id',$sm_type_details['id'])->exists()){
                    $company_details = CompanySocialAccount::where('status','active')->where('sm_type_id',$sm_type_details['id'])->get();
                    foreach ($company_details as $company_detail) {
                        $sm_type_id = $company_detail->sm_type_id;
                        $page_id = $company_detail->page_id;
                        $company_id = $company_detail->company_id;
                        if(Company::where('id',$company_id)->where('status','active')->exists()){
                            $this->twitter_post($page_id, $company_id, $sm_type_id, $twitter_conf);

                            //Call mention related function
                            $this->twitter_post_mention($page_id, $company_id, $sm_type_id, $twitter_conf);
                            //update company social account duration all to 1 day after first iteration
                            if($company_detail->data_pull_duration == 'all'){
                                $company_detail->data_pull_duration = 1;
                                $company_detail->update();
                            }
                        }
                    }
                }else{
                    print "No company found related ".$sm_type_specific." social media type.\n";exit;
                }
            }else{
                print "No ".$sm_type_specific." media type found\n";
            }
        }else{
            //specific company Twitter
            if(Company::where('id', $company_id)->where('status','active')->exists()){
                $company_details = Company::where('id', $company_id)->where('status','active')->first();
                if(SmType::where('type', $sm_type_specific)->where('status','active')->exists()){
                    $sm_type_id = SmType::where('type', $sm_type_specific)->where('status','active')->first();
                    if(CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id',$sm_type_id['id'])->where('status','active')->exists()){
                        $company_social_account = CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id',$sm_type_id['id'])->where('status','active')->get();
                        foreach ($company_social_account as $com_s_acc) {
                            $sm_type_id = $com_s_acc->sm_type_id;
                            $page_id = $com_s_acc->page_id;
                            $company_id = $com_s_acc->company_id;
                            $this->twitter_post($page_id, $company_id, $sm_type_id, $twitter_conf);
                            $this->twitter_post_mention($page_id, $company_id, $sm_type_id, $twitter_conf);
                            //update company social account duration all to 1 day after first iteration
                            if($com_s_acc->data_pull_duration == 'all'){
                                $com_s_acc->data_pull_duration = 1;
                                $com_s_acc->update();
                            }
                        }
                    }
                }
            }
        }
    }

    public function twitter_post_mention($page_id, $company_id, $sm_type_id ,$twitter_conf){
        $count = 200;
        $max_id = 'init';
        while($max_id != null){
            try {
                $twitter = $this->twitter_auth();

                // Have to use max_id Ref:: http://techiella.x0.com/twitter-search-using-the-twitter-api-php/
                if($max_id == 'init'){
                    $posts = $twitter->get('search/tweets', ['q' => '#'.$page_id, 'count' => $count]);
                }
                else {
                    $posts = $twitter->get('search/tweets', ['q' => '#'.$page_id, 'count' => $count, 'max_id' => $max_id]);
                }
                //Log::info(print_r($posts, true));
                //print_r($posts);
                //exit('PPPP');
                foreach ($posts->statuses as $post) {
                    $post->sm_type_id = $sm_type_id;
                    $post->company_id = $company_id;
                    print 'Done: ' . $this::$i . "\n";
                    $this->save_twitter_post($post, 'mention');
                    $max_id = $post->id_str;
                    print $post->text."\n";
                    print $max_id."\n";
                };
                print "--------------------------------------------------------------------\n";
            }catch(\Exception $ex){
                $page = null;
                Log::error('Twitter:'.$ex->getMessage());
            }
        }
        return true;
    }

    public function twitter_post($page_id, $company_id, $sm_type_id ,$twitter_conf){
        $count = 200;
        $page = 1;
        $no_of_post = 1;
        while($page != null){
            try {
                $twitter = $this->twitter_auth();
                $posts = $twitter->get('statuses/user_timeline', ['screen_name'=>$page_id, 'count'=>$count, 'page'=>$page]);

                foreach ($posts as $post) {
                    $post->sm_type_id = $sm_type_id;
                    $post->company_id = $company_id;
                    print $no_of_post."====".$post->text."===\n";
                    print 'Done: ' . $this::$i ."\n";
                    $this->save_twitter_post($post);
                    $no_of_post++;
                }
                if (count($posts) == null) {
                    $page = null;
                } else {
                    $page++;
                }
            }catch(\Exception $ex){
                $page = null;
                Log::error('Twitter:'.$ex->getMessage());
            }
        }
        return true;
    }
    public function save_twitter_post($post_obj, $mention = null){
        $start_time = date("Y-m-d\TH:i:s") . substr((string)microtime(), 1, 8);
        if(isset($post_obj->text)){
            $data_pull_duration = SmType::getDuration($post_obj->company_id, $post_obj->sm_type_id);
            if(SmType::past_time($post_obj->created_at, $data_pull_duration)) {
                $post = Post::firstOrNew(['post_id' => $post_obj->id]);
                $post->post = $post_obj->text;
                $post->post_id = $post_obj->id;
                $post->company_id = $post_obj->company_id;
                $post->sm_type_id = $post_obj->sm_type_id;
                $old_date_timestamp = strtotime($post_obj->created_at);
                $new_date = date('Y-m-d H:i:s', $old_date_timestamp);
                $post->post_date = $new_date;
                if($mention){
                    $post->mention = 1;
                }else{
                    $post->mention = 0;
                }
                try {
                    $post->save();
                    Log::info('Twitter save. #'.$this::$i." :: ".date('d/m/y h:m:s'));
                    $this::$i++;
                } catch (\Exception $ex) {
                    Log::error('Twitter error: '.$ex->getMessage());
                }
            }
        }else{
            Log::info('Twitter :: No text. '.date('d/m/y h:m:s'));
            print "______-------______-----_______------________--------____________";
            print_r($post_obj);
            print "______-------______-----_______------________--------____________";
        }
        echo 'Company ID:'.$post_obj->company_id." Post ID: ".$post_obj->id."\n";
        $end_time = date("Y-m-d\TH:i:s") . substr((string)microtime(), 1, 8);
        print 'Start_time: '.$start_time."\n";
        print 'End_time: '.$end_time."\n";
        return true;
    }
}
