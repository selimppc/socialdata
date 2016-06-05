<?php
/**
 * Created by PhpStorm.
 * User: etsb
 * Date: 5/26/16
 * Time: 12:57 PM
 */

namespace App\Modules\Www\Controllers;

use App\Http\Controllers\Controller;
use App\CompanySocialAccount;
use App\SmType;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Helpers\FacebookHelper;
use Illuminate\Support\Facades\Session;

class SocialMediaController extends Controller
{
    public function index(){
        $data['pageTitle']='Social Media Status';
        $data['social_medias']=SmType::with(['relCompanySocialAccount'=>function($query){
            $query->where('company_id',\Session::get('companyId'));
        }])->get();

        #dd($data);
        foreach ($data['social_medias'] as $id=>$social_media) {

            foreach ($social_media->relCompanySocialAccount as $user_social_account) {
                if(empty($user_social_account->sm_account_id))
                {
                    if($user_social_account->sm_type_id==2)
                    {
                        $loginUrl= FacebookHelper::getLoginUrl($user_social_account->id);
                        $data['social_medias'][$id]->loginUrl = $loginUrl;
                        $data['social_medias'][$id]->button_text = 'Subscribe with Facebook';
                    }elseif($user_social_account->sm_type_id==3){
                        $data['social_medias'][$id]->loginUrl = '#';
                        $data['social_medias'][$id]->button_text = 'Subscribe with Twitter';
                    }elseif($user_social_account->sm_type_id==1){
                        $data['social_medias'][$id]->loginUrl = '#';
                        $data['social_medias'][$id]->button_text = 'Subscribe with Google+';
                    }
                    $data['social_medias'][$id]->btnClass='info';
                }else{
                    $data['social_medias'][$id]->loginUrl = '#';
                    $data['social_medias'][$id]->button_text = 'Already Subscribe';
                    foreach ($social_media->relCompanySocialAccount as $user_social_account) {
                        if($user_social_account->sm_type_id==2)
                        {
                            $data['social_medias'][$id]->user_sm_id = $user_social_account->id;
                            $data['social_medias'][$id]->button_text_data = 'Get Data';

                        }
                    }
                    $data['social_medias'][$id]->btnClass='primary';

                }
            }

        }
        return view('www::social_media.index',$data);
    }
    public function social_media_return($social_media_type,$company_social_media_id){
        if($social_media_type=='facebook')
        {
            $status=FacebookHelper::facebook_return();
            if(isset($status) && isset($status['userNode']) && isset($status['longLiveAccessToken'])) {
                /*
                 * store data on user social account
                 * */

                $userSocial = CompanySocialAccount::findOrFail($company_social_media_id);
                $userSocial->sm_account_id = $status['userNode']->getId();
                $userSocial->access_token = $status['longLiveAccessToken'];
                $userSocial->save();
                \Session::flash('message', 'Successfully Subscribe.');

            }else{
                Session::flash('error',$status);
            }
            return redirect('www/add-social-media');
        }
    }
    public function get_posts($user_social_media_id)
    {
        $config=FacebookHelper::getFbConfig();
        $fb = new Facebook($config);
        $app_data= CompanySocialAccount::findOrFail($user_social_media_id);

        $posts=$fb->get($app_data->sm_account_id.'/posts?limit=500',$app_data->access_token);

        $total_post=[];
        $posts_response=$posts->getGraphEdge();
        if($fb->next($posts_response))
        {
            foreach ($fb->next($posts_response) as $values) {
                dd($values);
            }

        }
        dd($posts_response);
    }

}