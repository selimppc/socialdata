<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user table seed
        /*DB::statement("SET foreign_key_checks = 0");
        DB::table('users')->truncate();
        $users = array(
            array('admin','admin@admin.com', Hash::make('admin'),'admin','active','fioyugpuiesiorgjhprauehrigpi','active')
        );
        foreach($users as $user) {
            \App\User::insert(array(
                'name' => $user[0],
                'email' => $user[1],
                'password' => $user[2],
                'type' => $user[3],
                'status' => $user[4],
                'remember_token' => $user[5],
                'status' => $user[6],
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }*/

        //sm_type table seeder
        DB::statement("SET foreign_key_checks = 0");
        DB::table('sm_type')->truncate();
        //$country_id = DB::table('country')->select('id')->where('title', 'Bangladesh ')->first()->id;
        $sm_type = array(
            array('google_plus','active')
        );
        foreach($sm_type as $sm_types) {
            \App\SmType::insert(array(
                'type' => $sm_types[0],
                'status' => $sm_types[1],
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }

        //Company table seeder
        DB::statement("SET foreign_key_checks = 0");
        DB::table('company')->truncate();
        $company = array(
            array('devdhaka405','active'),
            array('bank of america','active')
        );
        foreach($company as $companys) {
            \App\Company::insert(array(
                'name' => $companys[0],
                'status' => $companys[1],
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }

        //Company Social account table seeder
        DB::statement("SET foreign_key_checks = 0");
        DB::table('company_social_account')->truncate();
        $company_social_account = array(
            array('111786072963538463758',1, 1,'active'),
            array('+BankofAmerica',2, 1, 'active')
        );
        foreach($company_social_account as $company_social_accounts) {
            \App\CompanySocialAccount::insert(array(
                'sm_account_id' => $company_social_accounts[0],
                'company_id' => $company_social_accounts[1],
                'sm_type_id' => $company_social_accounts[2],
                'status' => $company_social_accounts[3],
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
