<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
          $emails = \DB::table('emails')->get();
          foreach ($emails as $email) {
            if($email->mails_today != 0){
                \DB::table('emails')->where('id', $email->id)->update(['mails_total' => $email->mails_total+$email->mails_today]);
                if($email->status == 1){
                  \DB::table('emails')->where('id', $email->id)->update(['status' => 0]);
                }
            }
          }
          \DB::table('emails')->update(['mails_today' => 0]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
