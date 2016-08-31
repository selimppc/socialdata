<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        #\App\Console\Commands\Inspire::class,
        \App\Console\Commands\GetEmailQueue::class,
        \App\Console\Commands\GetPoppedMessage::class,
        \App\Console\Commands\SendEmailQueue::class,
        \App\Console\Commands\GooglePlus::class,
        \App\Console\Commands\Facebook::class,
        \App\Console\Commands\Twitter::class,
        \App\Console\Commands\PostSchedule::class,
        \App\Console\Commands\PostNofify::class,
        \App\Console\Commands\Instagram::class,
        \App\Console\Commands\Metric::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        #$schedule->command('get:emailqueue')->hourly();
        #$schedule->command('get:poppedmessage')->hourly();
        #$schedule->command('set:emailsend')->everyMinute();
        /*$schedule->command('get:twitter')->everyFiveMinutes();
        $schedule->command('get:facebook')->everyFiveMinutes();
        $schedule->command('get:googleplus')->everyFiveMinutes();*/
        /*$schedule->command('get:twitter')->hourly();
        $schedule->command('get:facebook')->hourly();
        $schedule->command('get:googleplus')->hourly();*/
        // every hour
        $schedule->command('get:twitter')->hourly();
        $schedule->command('get:instagram')->hourly();
        // every one and a half hours
        $schedule->command('get:facebook')->cron('0 0,3,6,9,12,15,18,21 * * * *');
//        $schedule->command('get:facebook')->cron('30 1,4,7,10,13,16,19,22 * * * *');
        // every two hours at x.15 minutes (0.15, 2.15, 4.15 etc)
        //$schedule->command('get:googleplus')->cron('15 */2 * * * *');
        // every 1.45 hour
        $schedule->command('get:googleplus')->cron('0 7,14,21 * * * *');
//        $schedule->command('get:googleplus')->cron('15 5,12,19 * * * *');
//        $schedule->command('get:googleplus')->cron('30 3,10,17 * * * *');
//        $schedule->command('get:googleplus')->cron('45 1,8,15,22 * * * *');

        // Schedule for post on social media
        $schedule->command('post:schedule')->everyMinute();
        // notify before post on social media
        $schedule->command('post:notify')->everyMinute();
        // Pull Instagram data
        $schedule->command('get:instagram')->hourly();
        $schedule->command('get:metric')->daily();
    }
}
