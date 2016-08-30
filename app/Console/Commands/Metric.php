<?php

namespace App\Console\Commands;

use App\CompanySocialAccount;
use App\Helpers\FacebookHelper;
use Illuminate\Console\Command;

class Metric extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:metric';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get metrics from social media';

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
        $company_social_accounts=CompanySocialAccount::where('sm_type_id',2)->where('sm_account_id','!=','')->get();
//        dd($company_social_accounts);
        $i=0;
        foreach ($company_social_accounts as $company_social_account) {
            print ++$i.". Facebook Account Found \n";
            $data=FacebookHelper::metric($company_social_account->access_token,$company_social_account->page_id);
            dd($data);
            $data=$data->getDecodedBody('data');
//            dd($data['data']);
            FacebookHelper::storeData($data['data'],$company_social_account);
        }
    }
}
