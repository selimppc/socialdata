<?php

namespace App\Console\Commands;

use App\Comment;
use App\Company;
use App\CompanySocialAccount;
use App\Helpers\GooglePlusHelper;
use App\Post;
use App\SmType;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GooglePlus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:googleplus {user_id=1}{company_id=0}{sm_type_id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get post from google plus account';

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
    private function plus(){
        $sm_type = SmType::where('type','google_plus')->first();
        if ($sm_type->access_token != null) {
            $client = new \Google_Client();
            $client->setAuthConfigFile(public_path() . '/apis/client_secret_974791274339-doct333hjkdob6mccquvuo21k662s7m5.apps.googleusercontent.com.json');
            $client->addScope(SCOPES);
            $client->setLoginHint('');
            $client->setAccessType('offline');
            $client->setApprovalPrompt("force");
            $client->setAccessToken($sm_type->access_token);
            if ($client->isAccessTokenExpired()) {
                $refresh_token = $client->getRefreshToken();
                $client->refreshToken($refresh_token);
            }
            $plus = new \Google_Service_Plus($client);
            return $plus;
        } else {
            print "Access token not found";
            return false;
        }
    }
    private static $i = 0;
    public function handle()
    {
        $company_social_accounts=CompanySocialAccount::where('sm_type_id',1)->where('sm_account_id','!=','')->get();
//        dd($company_social_accounts);
        $i=0;
        foreach ($company_social_accounts as $company_social_account) {
            print ++$i.". Google Plus Account Found \n";
            $data=GooglePlusHelper::getPosts($company_social_account->access_token,$company_social_account->page_id);
            GooglePlusHelper::storeData($data,$company_social_account);
        }






//        session_start();
//        try {
//            $user_id = $this->argument('user_id');
//            $company_id = $this->argument('company_id');
//            $sm_type_id = 1;/*$this->argument('sm_type_id')*/
//            $sm_type_specific = 'google_plus';
//
//            //google authentication with access token
//            define('SCOPES', implode(' ', array(
//                    'https://www.googleapis.com/auth/plus.me'
//                )
//            ));
//            //$sm_type = SmType::findOrFail($sm_type_id);
//            $sm_type = SmType::where('type','google_plus')->first();
//            if ($sm_type->access_token != null) {
//                /*$client = new \Google_Client();
//                $client->setAuthConfigFile(public_path() . '/apis/client_secret_974791274339-doct333hjkdob6mccquvuo21k662s7m5.apps.googleusercontent.com.json');
//                $client->addScope(SCOPES);
//                $client->setLoginHint('');
//                $client->setAccessType('offline');
//                $client->setApprovalPrompt("force");
//                $client->setAccessToken($sm_type->access_token);
//                if ($client->isAccessTokenExpired()) {
//                    $refresh_token = $client->getRefreshToken();
//                    $client->refreshToken($refresh_token);
//                }
//                $plus = new \Google_Service_Plus($client);*/
//                //for all company google plus
//                if ($company_id == 0) {
//                    if (SmType::where('type', $sm_type_specific)->where('status', 'active')->exists()) {
//                        $sm_type_details = SmType::where('type', $sm_type_specific)->where('status', 'active')->first();
//                        if (CompanySocialAccount::where('status', 'active')->where('sm_type_id', $sm_type_details['id'])->exists()) {
//                            $company_details = CompanySocialAccount::where('status', 'active')->where('sm_type_id', $sm_type_details['id'])->get();
//                            foreach ($company_details as $company_detail) {
//                                $sm_type_id = $company_detail->sm_type_id;
//                                $page_id = $company_detail->page_id;
//                                $company_id = $company_detail->company_id;
//                                if (Company::where('id', $company_id)->where('status', 'active')->exists()) {
//                                    $this->google_post($page_id, $company_id, $sm_type_id);
//                                    //update company social account duration all to 1 day after first iteration
//                                    if($company_detail->data_pull_duration == 'all'){
//                                        $company_detail->data_pull_duration = 1;
//                                        $company_detail->update();
//                                    }
//                                }
//                            }
//                        } else {
//                            print "No company found related " . $sm_type_specific . " social media type.\n";
//                            exit;
//                        }
//                    } else {
//                        print "No " . $sm_type_specific . " media type found\n";
//                    }
//                } else {
//                    //specific company google plus
//                    if (Company::where('id', $company_id)->where('status', 'active')->exists()) {
//                        $company_details = Company::where('id', $company_id)->where('status', 'active')->first();
//                        if (SmType::where('type', $sm_type_specific)->where('status', 'active')->exists()) {
//                            $sm_type_id = SmType::where('type', $sm_type_specific)->where('status', 'active')->first();
//                            if (CompanySocialAccount::where('company_id', $company_id)->where('sm_type_id', $sm_type_id['id'])->where('status', 'active')->exists()) {
//                                $company_social_account = CompanySocialAccount::where('company_id', $company_id)->where('sm_type_id', $sm_type_id['id'])->where('status', 'active')->get();
//                                foreach ($company_social_account as $com_s_acc) {
//                                    $sm_type_id = $com_s_acc->sm_type_id;
//                                    $page_id = $com_s_acc->page_id;
//                                    $company_id = $com_s_acc->company_id;
//                                    $this->google_post($page_id, $company_id, $sm_type_id);
//                                    //update company social account duration all to 1 day after first iteration
//                                    if($com_s_acc->data_pull_duration == 'all'){
//                                        $com_s_acc->data_pull_duration = 1;
//                                        $com_s_acc->update();
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//                exit;
//            } else {
//                print "Access token not found";
//            }
//        }catch(\Exception $e){
//            Log::error('GooglePlus:'.$e->getMessage());
//        }
    }

    //google plus data fetch
    public function google_post($account_id, $company_id, $sm_type_id){
        $plus = $this->plus();
        if($plus) {
            $pageToken = 1;
            while ($pageToken != null) {
                try {
                    $optParams = array('maxResults' => 100, 'pageToken' => $pageToken);
                    $activities = $plus->activities->listActivities($account_id, 'public', $optParams);
                    $pageToken = $activities->nextPageToken;
                    $start_time = date("Y-m-d\TH:i:s") . substr((string)microtime(), 1, 8);
                    foreach ($activities['items'] as $item) {
                        if (isset($item['object']['content'])) {
                            $data_pull_duration = SmType::getDuration($company_id, $sm_type_id);
                            if (SmType::past_time($item['published'], $data_pull_duration)) {
                                $post = Post::firstOrNew(['post_id' => $item['id']]);
                                $post->post = $item['object']['content'];
                                $post->post_id = $item['id'];
                                $post->company_id = $company_id;
                                $post->sm_type_id = $sm_type_id;
                                //date conversion
                                $old_date_timestamp = strtotime($item['published']);
                                $new_date = date('Y-m-d H:i:s', $old_date_timestamp);
                                $post->post_date = $new_date;
                                //date conversion
                                $old_date_timestamp1 = strtotime($item['updated']);
                                $new_date1 = date('Y-m-d H:i:s', $old_date_timestamp1);
                                $post->post_update = $new_date1;
                                try {
                                    $post->save();
                                    Log::info('Googleplus save'.date('d/m/y h:m:s'));
                                    $this->google_comment($post->id, $post->post_id);
                                    $this::$i++;
                                } catch (\Exception $ex) {
                                    Log::error('GooglePlus:' . $ex->getMessage());
                                }
                            }
                        } else {
                            print "______-------______-----_______------________--------____________";
                            print_r($item);
                            print "______-------______-----_______------________--------____________";
                        }
                        $end_time = date("Y-m-d\TH:i:s") . substr((string)microtime(), 1, 8);
                        print 'Done: ' . $this::$i . "\n";
                        print 'Company ID:' . $company_id . "\n";
                        print 'Start_time: ' . $start_time . "\n";
                        print 'End_time: ' . $end_time . "\n";
                    }
                } catch (\Exception $ex) {
                    $pageToken = null;
                    Log::error('GooglePlus:' . $ex->getMessage());
                }
            }
        }else{
            print "Wrong in google api authentication.. \n";
        }
    }

    public function google_comment($post_id, $post_actual_id){
        $plus = $this->plus();
        $pageTokenComment = 1;
        if($plus){
            while($pageTokenComment != null){
                try {
                    if ($pageTokenComment != 1) {
                        $optParams = array('maxResults' => 100, 'pageToken' => $pageTokenComment);
                    } else {
                        $optParams = array('maxResults' => 100);
                    }
                    $comments = $plus->comments->listComments($post_actual_id, $optParams);
                    $pageTokenComment = $comments->nextPageToken;
                    foreach ($comments as $comment) {
                        if ($comment['object']['content']) {
                            $comment_post = Comment::firstOrNew(['comment_id' => $comment['id']]);
                            $comment_post->comment = $comment['object']['content'];
                            $comment_post->post_id = $post_id;
                            $comment_post->comment_id = $comment['id'];
                            //date conversion
                            $old_date_timestamp = strtotime($comment['published']);
                            $new_date = date('Y-m-d H:i:s', $old_date_timestamp);
                            $comment_post->comment_date = $new_date;
                            try {
                                $comment_post->save();
                                print "comment done \n";
                            } catch (\Exception $ex) {
                                print $ex->getMessage() . "\n";
                                Log::error('GooglePlus Comment:' . $ex->getMessage());
                            }
                        } else {
                            print "No comment available_____________----------------_________________\n";
                        }
                    }
                }catch(\Exception $ex){
                    $pageTokenComment = null;
                    Log::error('GooglePlus comment:'.$ex->getMessage());
                }
            }
        }else{
            print "Something wrong in google API \n";
        }
        return true;
    }
}
