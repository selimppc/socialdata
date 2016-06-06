<?php

namespace App\Console\Commands;

use App\ArchiveSchedule;
use App\CompanySocialAccount;
use App\CustomPost;
use App\PostSocialMedia;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Helpers\FacebookHelper;
use App\Helpers\TwitterHelper;

class PostSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduled post has been post on social media';

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
        $schedules= Schedule::where('time','<',Carbon::now())->with('relCustomPost')->get();
//        dd($schedules);
        if(isset($schedules) && count($schedules)>0)
        {
            foreach ($schedules as $schedule) {
                if(isset($schedule->relCustomPost) && count($schedule->relCustomPost)>0)
                {
                    $company_id=$schedule->relCustomPost['company_id'];
                    $id=$schedule->relCustomPost['id'];
                    $socialMediaToPost= PostSocialMedia::select('social_media_id')->where('custom_post_id',$id)->where('status','new')->get();
                    if(isset($socialMediaToPost)) {
                        $i=0;
                        foreach ($socialMediaToPost as $smtp) {
                            if ($smtp->social_media_id == 1) {
                                $i++;
                            } elseif ($smtp->social_media_id == 2) {
                                $status = FacebookHelper::publish($id,$company_id);
                                dd($status);
                                if(isset($status) && $status=='success')
                                {
                                    $i++;
                                }
                            } elseif ($smtp->social_media_id == 3) {
                                $status = TwitterHelper::publish($id,$company_id);
                                if(isset($status) && $status=='success')
                                {
                                    $i++;
                                }
                            }
                        }
                        if(count($socialMediaToPost) == $i)
                        {
                            $custom_post=CustomPost::findOrFail($id);
                            $custom_post->status= 'sent';
                            $custom_post->save();
                            $this->StoreArchiveSchedule($schedule);
                            Schedule::destroy($schedule->id);
                        }
                    }
                }
            }
        }
    }


    private function StoreArchiveSchedule($schedule)
    {
        $archiveSchedule= new ArchiveSchedule();
        $archiveSchedule->custom_post_id=$schedule->custom_post_id;
        $archiveSchedule->time=$schedule->time;
        $archiveSchedule->schedule_created_by=$schedule->created_by;
        $archiveSchedule->schedule_updated_by=$schedule->updated_by;
        $archiveSchedule->schedule_created_at=$schedule->created_at;
        $archiveSchedule->schedule_updated_at=$schedule->updated_at;
        return $archiveSchedule->save();
    }
}
