<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAllMails extends Mailable
{
    use Queueable, SerializesModels;

    protected $my_message;
    protected $my_subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($my_subject, $my_message)
    {
      //dd($my_email->email);
      $this->my_subject = $my_subject;
      $this->my_message = $my_message;
      extract(\Config::get('mail'));
      // create new mailer with new settings
      $transport = (new \Swift_SmtpTransport($host, $port))
                           ->setUsername($username)
                           ->setPassword($password)
                           ->setEncryption($encryption);
      \Mail::setSwiftMailer(new \Swift_Mailer($transport));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->my_subject)->view('my_mail')->with('my_message', $this->my_message);
    }
}
