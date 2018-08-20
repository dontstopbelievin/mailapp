<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use App\My_Jobs;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
          Queue::before(function (JobProcessing $event) {
            //CHECK FOR ATTEMPTS
            //dump('before Queue');
            //if($event->job->isReleased()){dump('queue before: released');}
            //if($event->job->isDeleted()){dump('queue before: deleted');}

            //$my_attempts = \DB::table('emails')->where('email', \Config::get('mail.username'))->value('attempts_today');
            //dump($my_attempts);
            /*$my_jobs = my_jobs::find(1);
            if($attempt > $my_jobs->all_today_attempts){
              $my_jobs->all_today_attempts = $attempt;
              $my_jobs->save();
            }*/
            //dump($my_jobs->all_today_attempts);
              // $event->connectionName
              // $event->job
              // $event->job->payload()
          });

          Queue::after(function (JobProcessed $event) {
            //dump('after Queue');
            //if($event->job->isReleased()){dump('queue after: released');}
            //if($event->job->isDeleted()){dump('queue after: deleted');}
              // $event->connectionName
              // $event->job
              // $event->job->payload()
          });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
