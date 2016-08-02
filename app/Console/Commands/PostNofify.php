<?php

namespace App\Console\Commands;

use App\CustomPost;
use App\PostSocialMedia;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PostNofify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to the post creator.';

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
    public function handle()
    {
        //
        $postToNotify=CustomPost::where('execute_time','<=',Carbon::now())->where('execute_time','<=',Carbon::now())->where('is_executed',0)->with('relUser')->get();
//        dd($postToNotify);
        if(isset($postToNotify) && count($postToNotify)>0) {
            foreach ($postToNotify as $ptn) {
                $data['postData']=$ptn;
                $data['socialMediaToPost'] = PostSocialMedia::select('social_media_id')->with('relSmType')->where('custom_post_id', $ptn->id)->where('status', 'new')->get();
//                dd($data['socialMediaToPost'][0]->relSmType);
                Mail::send('www::custom_post.notify_email',$data,function($mail) use($ptn){
                    $mail->from('info@socialdata.com','Social Data');
                    $mail->to($ptn->relUser['email'],'Social Data')->subject('Post Notification');
                });

                $executed= CustomPost::findOrFail($ptn->id);
                $executed->is_executed=1;
                $executed->save();
            }

        }
    }
}
