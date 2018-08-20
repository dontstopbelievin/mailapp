<?php

namespace App\Listeners;
use App\Emails;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSentMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
      //dump('sent is here');
      $current_user = Emails::where('email', \Config::get('mail.username'))->first();
      $current_user->mails_today++;
      $current_user->save();
    }
}
