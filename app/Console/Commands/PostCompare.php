<?php

namespace App\Console\Commands;

use App\Company;
use App\CompanySocialAccount;
use App\CustomPost;
use App\Post;
use App\PostSocialMedia;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PostCompare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compare:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compare Posts';

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
        $yesterday=Carbon::yesterday();
        // Get all companies
        $companies= Company::get();
        $i=1;
        // Start looping in company
        foreach ($companies as $company) {
            // Get activated social accounts of this company
            $company_social_accounts= CompanySocialAccount::where('company_id',2)->whereIn('sm_type_id',[2,3])->get();
            //Check if social accounts not null
            if(count($company_social_accounts)>0) {
                // Start looping on Company Social Accounts
                $message=[];
                foreach ($company_social_accounts as $company_social_account) {
                    if($company_social_account->sm_type_id==2)
                    {
                        $social_media='facebook';
                    }elseif($company_social_account->sm_type_id==3)
                    {
                        $social_media='twitter';
                    }
                    // Count custom posts of this company and social media
                    $custom_post=DB::table('post_social_media')
                        ->RightJoin('custom_posts','custom_posts.id','=','post_social_media.custom_post_id')
                        ->where('custom_posts.status','=','sent')
                        ->where('post_social_media.company_id','=',$company->id)
                        ->where('post_social_media.social_media_id','=',$company_social_account->sm_type_id)
                        ->where('post_social_media.created_at',$yesterday)
                        ->count();

                    // Count Posts of this company and social media
                    $posts=Post::where('company_id',$company->id)->where('sm_type_id',$company_social_account->sm_type_id)->where('created_at',$yesterday)->count();
                    if($custom_post==$posts)
                    {
                        $message[$social_media]='No Risk Found on '.$social_media;
                    }elseif($custom_post<$posts)
                    {
                        $message[$social_media]='Someone posting on your wall outside of SocialData app. Be Careful about your '.$social_media;
                    }
                }
                $user=User::where('company_id',$company->id)->first();
                if($user!=null) {
                    Mail::send('email.postCompareEmail', ['data' => $message], function ($mail) use ($user) {

                        $mail->from('info@socialdata.com', 'Social Data');

                        $mail->to($user->email);
                        $mail->subject('Daily Alert');

                    });
                    echo '::: ' . $i++ . ' Company done ::: <br> ';
                }
            }
        }
    }
}
