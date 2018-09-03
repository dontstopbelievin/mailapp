<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\SendAllMails;
use Carbon\Carbon;
use App\Emails;

class SendAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $my_message;
    protected $my_subject;
    protected $reciever;
    public $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($my_subject, $my_message, $reciever)
    {
        $this->my_subject = $my_subject;
        $this->my_message = $my_message;
        $this->reciever = $reciever;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            // CHECK IF THERE ARE AVAILABLE POSTMAN
            if((\Config::get('mail.username')) != null && (\Config::get('mail.username')) != '')
            {
              // CHECK MAX ATTEMPTS FOR CURRENT POSTMAN
              $email = \DB::table('emails')->where('email', \Config::get('mail.username'))->first();
              if($email->mails_today >= 500 || $email->status != 0)
              {
                if($email->status == 0){
                    \DB::table('emails')->where('email', \Config::get('mail.username'))->update(['status' => 1]);
                }
                  // TRY TO FIND AVAILABLE POSTMAN
                  $available_postman = \DB::table('emails')->where('status', 0)->first();
                  if($available_postman){
                      \Config::set('mail.username',$available_postman->email);
                  }else{
                      \Config::set('mail.username','');
                  }
              }
            }else{
                // TRY TO FIND AVAILABLE POSTMAN
                $available_postman = \DB::table('emails')->where('status', 0)->first();
                if($available_postman){
                    \Config::set('mail.username',$available_postman->email);
                }else{
                    // NO AVAILABLE POSTMAN LET ERROR HANDLER TO RELEASE THE JOB TO THE QUEUE
                }
            }

            // TRY SENDING MESSAGE
            Mail::to($this->reciever)->send(new SendAllMails($this->my_subject, $this->my_message));
        }catch(\Swift_RfcComplianceException $e){
          //INCORRECT EMAIL --DELAY FOR TOMMOROW--
          //dump($this->reciever);
          $timelapse = strtotime('tomorrow') - time();
          $this->job->release($timelapse);
        }catch(\Swift_TransportException $e){
          dump($e);
          // RELEASING JOB TO THE QUEUE AND CHANGING POSTMAN IF POSSIBLE --EXCEEDED MESSAGE LIMIT--
          if((\Config::get('mail.username')) != null && (\Config::get('mail.username')) != '')
          {
            \DB::table('emails')->where('email', \Config::get('mail.username'))->increment('attempts_today');
            if(\DB::table('emails')->where('email', \Config::get('mail.username'))->value('mails_today') >= 500){
              //ONE DAY LIMIT EXCEEDED
              \DB::table('emails')->where('email', \Config::get('mail.username'))->update(['status' => 1]);
              $available_postman = \DB::table('emails')->where('status', 0)->first();
              if ($available_postman) {
                dump('postman exceeded 500');
                 \Config::set('mail.username',$available_postman->email);
                 $this->job->release();
              }else{
                dump('no postmans');
                \Config::set('mail.username','');
                $timelapse = strtotime('tomorrow') - time();
                $this->job->release($timelapse);
                \DB::table('jobs')->update(['available_at' => $timelapse]);
              }
            }else{
              //~TOO MANY REQUESTS~
              dump('delay for 5 min ');
              $this->job->release(300);
              $available_postman = \DB::table('emails')->where('status', 0)->orderBy('mails_today', 'asc')->first();
              if ($available_postman) {
                 \Config::set('mail.username',$available_postman->email);
              }
              //DELAY ALL REQUESTS IF TOO MANY ATTEMPTS
              $emails = \DB::table('emails')->get();
              $sum = 0;
              foreach ($emails as $email) {
                $sum += $email->attempts_today;
              }
              if($sum >= 10){
                dump('delay ALL for 5 min');
                foreach ($emails as $email) {
                  if($email->attempts_today !=0){
                      \DB::table('emails')->where('id', $email->id)->update(['attempts_total' => $email->attempts_total+$email->attempts_today]);
                  }
                }
                \DB::table('emails')->update(['attempts_today' => 0]);
                // UNRELIABLE LOOP
                $jobs = \DB::table('jobs')->get();
                foreach ($jobs as $job) {
                  switch (true){
                    case time() - $job->created_at < 3600:
                        \DB::table('jobs')->where('id', $job->id)->update(['available_at' => time() + 300]);
                        break;
                    case time() - $job->created_at < 3600*2:
                        \DB::table('jobs')->where('id', $job->id)->update(['available_at' => time() + 600]);
                        break;
                    case time() - $job->created_at < 3600*3:
                        \DB::table('jobs')->where('id', $job->id)->update(['available_at' => time() + 1200]);
                        break;
                    case time() - $job->created_at < 3600*4:
                        \DB::table('jobs')->where('id', $job->id)->update(['available_at' => time() + 1800]);
                        break;
                    default:
                      \DB::table('jobs')->where('id', $job->id)->update(['available_at' => time() + 300]);
                  }
                }
              }
            }
          }else{
            //NO POSTMANS AVAILABLE -> DELAY REQUESTS TO TOMORROW
            dump('no postmans');
            $timelapse = strtotime('tomorrow') - time();
            $this->job->release($timelapse);
            \DB::table('jobs')->update(['available_at' => $timelapse]);
          }
        }
        //if($this->job->isReleased()){dump('queue handle: released');}
    }

    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
        //dump('fucadfduck');
    }
}
