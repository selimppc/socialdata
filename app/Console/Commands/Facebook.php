<?php

namespace App\Console\Commands;

use App\Comment;
use App\Company;
use App\CompanySocialAccount;
use App\Post;
use App\SmType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Facebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:facebook {user_id=1}{company_id=0}{sm_type_id=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get facebook data';

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
    private static $i = 1;
    public function handle()
    {
        session_start();
        $company_id = $this->argument('company_id');
        $sm_type_id = $this->argument('sm_type_id');
        //all company facebook page
        if($company_id == 0){
            if(SmType::where('type','facebook')->where('status','active')->exists()){
                $sm_type_details = SmType::where('type','facebook')->where('status','active')->first();
                if(CompanySocialAccount::where('status','active')->where('sm_type_id',$sm_type_details['id'])->exists()){
                    $company_details = CompanySocialAccount::where('status','active')->where('sm_type_id',$sm_type_details['id'])->get();
                    foreach ($company_details as $company_detail) {
                        $sm_type_id = $company_detail->sm_type_id;
                        $page_id = $company_detail->page_id;
                        $company_id = $company_detail->company_id;
                        if(Company::where('id',$company_id)->where('status','active')->exists()){
                            $this->facebook_post($page_id, $sm_type_id, $company_id);
                            //update company social account duration all to 1 day after first iteration
                            /*DB::table('company_social_account')
                                ->where('id',$sm_type_id)
                                ->where('data_pull_duration', 'all')
                                ->update(['data_pull_duration' => "1"]);*/
                            if($company_detail->data_pull_duration == 'all'){
                                $company_detail->data_pull_duration = 1;
                                $company_detail->update();
                            }
                        }
                    }
                }else{
                    print "No company found related facebook social media type.\n";exit;
                }
            }else{
                print "No facebook media type found\n";
            }
        }else{
            //specific company facebook page
            if(Company::where('id', $company_id)->where('status','active')->exists()){
                $company_details = Company::where('id', $company_id)->where('status','active')->first();
                if(SmType::where('type','facebook')->where('status','active')->exists()){
                    $sm_type_id = SmType::where('type','facebook')->where('status','active')->first();
                    if(CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id',$sm_type_id['id'])->where('status','active')->exists()){
                        $company_social_account = CompanySocialAccount::where('company_id',$company_id)->where('sm_type_id',$sm_type_id['id'])->where('status','active')->get();
                        foreach ($company_social_account as $com_s_acc) {
                            $sm_type_id = $com_s_acc->sm_type_id;
                            $page_id = $com_s_acc->page_id;
                            $company_id = $com_s_acc->company_id;
                            $this->facebook_post($page_id, $sm_type_id, $company_id);
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
        exit;
    }

    public function facebook_post($page_id, $sm_type_id, $company_id)
    {
        $config = [
            'appId' => '969861563097945',
            'secret' => '6aaf0ad24ca10468aa788f67f3741396',
            //'default_graph_version' => 'v2.5',
        ];
        $facebook = new \Facebook($config);
        $limit = 20;

        // FB first call to get pagination next var
        $feed = $facebook->api("/$page_id/posts?limit=$limit");
        $content_id['paging']['next'] = isset($feed['paging']['next'])?$feed['paging']['next']:null;
        if(isset($feed['data'])){
            foreach ($feed['data'] as $item) {
                $item['sm_type_id'] = $sm_type_id;
                $item['company_id'] = $company_id;
                print 'Done: ' . $this::$i . "\n";
                $post = $this->save_post($item);
                //post comments get and save
                $this->post_comment($facebook, $limit, $post);
            }
        }

        // After first call, repeating until next in null
        while(isset($content_id['paging']['next']) != null){
            try {
                $page_token = $content_id['paging']['next'];
                $content_id = $facebook->api("/$page_id/posts?limit=$limit&__paging_token=$page_token");
                if(isset($content_id['data'])){
                    foreach ($content_id['data'] as $c_id) {
                        $c_id['sm_type_id'] = $sm_type_id;
                        $c_id['company_id'] = $company_id;
                        print 'Done: ' . $this::$i . "\n";
                        $post = $this->save_post($c_id);
                        //post comments get and save
                        $this->post_comment($facebook, $limit, $post);
                    }
                }
            }catch(\Exception $ex){
                $content_id['paging']['next'] = null;
                Log::error('Facebook:'.$ex->getMessage());
            }
        }
        return true;
    }

    public function save_post($post_array)
    {
        try {
            $start_time = date("Y-m-d\TH:i:s") . substr((string)microtime(), 1, 8);
            if (isset($post_array['message'])) {
                $data_pull_duration = SmType::getDuration($post_array['company_id'], $post_array['sm_type_id']);
                if(SmType::past_time($post_array['created_time'], $data_pull_duration)) {
                    $post = Post::firstOrNew(['post_id' => $post_array['id']]);
                    $post->post = $post_array['message'];
                    $post->post_id = $post_array['id'];
                    $post->company_id = $post_array['company_id'];
                    $post->sm_type_id = $post_array['sm_type_id'];
                    $old_date_timestamp = strtotime($post_array['created_time']);
                    $new_date = date('Y-m-d H:i:s', $old_date_timestamp);
                    $post->post_date = $new_date;
                    try {
                        $post->save();
                        Log::info('Facebook save'.date('d/m/y h:m:s'));
                        $this::$i++;
                    } catch (\Exception $ex) {
                        Log::error($ex->getMessage());
                    }
                    print "Post saved \n";
                }
            }
            else{
                print "______-------______-----_______------________--------____________";
                print_r($post_array);
                print "______-------______-----_______------________--------____________";

            }
            echo 'Company ID:' . $post_array['company_id'] . "\n";
            $end_time = date("Y-m-d\TH:i:s") . substr((string)microtime(), 1, 8);
            print 'Start_time: ' . $start_time . "\n";
            print 'End_time: ' . $end_time . "\n";
            //for check post/status available or not
            if(isset($post)) {
                return $post;
            }else{
                return false;
            }
        }catch(\Exception $ex){
            Log::error('Facebook: '.$ex->getMessage());
        }
    }

    /*
     * get post comments
     * */
    public function post_comment($facebook, $limit, $post){
        if($post) {
            $comments = $facebook->api("/$post->post_id/comments?$limit");
            foreach ($comments['data'] as $comment) {
                $comment['post_id'] = $post->id;
                $this->save_comment($comment);
            }
            $comments_2['paging']['next'] = isset($comments['paging']['next']) ? $comments['paging']['next']: null;
            while(isset($comments_2['paging']['next']) != null){
                try {
                    $page_token = $comments['paging']['next'];
                    $comments_2 = $facebook->api("/$post->id/comments?limit=$limit&__paging_token=$page_token");
                    foreach ($comments_2['data'] as $comment_next) {
                        $comment_next['post_id'] = $post->id;
                        $this->save_comment($comment_next);
                    }
                }catch(\Exception $ex){
                    $comments_2['paging']['next'] = null;
                    Log::error('Facebook:'.$ex->getMessage());
                }
            }
        }
    }

    /*
     * save post comments
     * */
    public function save_comment($input)
    {
        if (isset($input['message'])) {
            $comment = Comment::firstOrNew(['comment_id' => $input['id']]);
            $comment->comment = $input['message'];
            $comment->post_id = $input['post_id'];
            $comment->comment_id = $input['id'];
            $old_date_timestamp = strtotime($input['created_time']);
            $new_date = date('Y-m-d H:i:s', $old_date_timestamp);
            $comment->comment_date = $new_date;
            try {
                if($input['message'] != '' || $input['message'] != null) {
                    $comment->save();
                    print "Comment saved \n";
                }
            } catch (\Exception $ex) {
                Log::error($ex->getMessage());
            }
        }
        else{
            print "______-------______-----_______------________--------____________";
            print_r($input);
            print "______-------______-----_______------________--------____________";

        }
    }
}
