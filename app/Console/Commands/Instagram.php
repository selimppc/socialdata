<?php

namespace App\Console\Commands;

use App\CompanySocialAccount;
use App\Helpers\InstagramHelper;
use Illuminate\Console\Command;

class Instagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:instagram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Data From Instagram Account';

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
        $company_social_accounts=CompanySocialAccount::where('sm_type_id',4)->where('sm_account_id','!=','')->get();
//        dd($company_social_accounts);
        foreach ($company_social_accounts as $company_social_account) {
            $data=InstagramHelper::getData($company_social_account->access_token);
            InstagramHelper::storeData($data,$company_social_account);
        }
    }
}
