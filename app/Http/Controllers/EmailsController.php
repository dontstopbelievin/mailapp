<?php

namespace App\Http\Controllers;

use App\Emails;
use App\Jobs\SendAll;
use Illuminate\Http\Request;
use Validator;

class EmailsController extends Controller
{

  public function index(){
    $emails = Emails::all();
    return view('emails')->with('emails', $emails);
  }

  public function my_queue(){
    $jobs = \DB::table('jobs')->get();
    return view('my_queue')->with('jobs', $jobs);
  }

  public function clear_attempts(){
    \DB::table('jobs')->update(['attempts' => 0]);
    return redirect('my_queue');
  }

  public function run_jobs(){
    \DB::table('jobs')->update(['available_at' => 0]);
    return redirect('my_queue');
  }

  public function failed_queue(){
    $failed_jobs = \DB::table('failed_jobs')->get();
    return view('failed_queue')->with('failed_jobs', $failed_jobs);
  }

  public function try_again($id){
    $failed_job = \DB::table('failed_jobs')->where('id', $id)->first();
    $time = time();
    \DB::table('jobs')->insert(
      ['queue' => 'default', 'payload' => $failed_job->payload, 'attempts' => 0, 'available_at' => $time, 'created_at' => $time]
    );
    \DB::table('failed_jobs')->where('id', $id)->delete();

    return redirect('failed_queue');
  }

  public function try_again_all(){
    $failed_jobs = \DB::table('failed_jobs')->get();
    $time = time();
    foreach ($failed_jobs as $failed_job) {
      \DB::table('jobs')->insert(
        ['queue' => 'default', 'payload' => $failed_job->payload, 'attempts' => 0, 'available_at' => $time, 'created_at' => $time]
      );
      \DB::table('failed_jobs')->where('id', $failed_job->id)->delete();
    }

    return redirect('failed_queue');
  }

  public function delete_failed_all(){
    \DB::table('failed_jobs')->truncate();
    return redirect('failed_queue');
  }

  public function my_postmans(){
    $emails = Emails::all();
    $active = $emails->filter(function ($value, $key) {
      return $value->status == 0;
    });
    $inactive = $emails->filter(function ($value, $key) {
      return $value->status == 1 || $value->status == 2;
    });
    return view('my_postmans')->with('emails', ['active' => $active, 'inactive' => $inactive]);
  }

  public function add_email(Request $request){
    $validator = Validator::make($request->all(),[
      'email' => 'required|string|email|max:255',
      'password' => 'required'
    ]);

    if($validator->fails()){
      $response = $validator->messages();
      session()->flash('my_error', $response);
      return redirect('my_postmans');
    }

    $email = new Emails;
    $email->email = $request->input('email');
    $email->password = $request->input('password');
    $email->mails_today = 0;
    $email->mails_total = 0;
    $email->attempts_today = 0;
    $email->attempts_total = 0;
    $email->status = 0;
    $email->save();

    return redirect('my_postmans');
  }

  public function delete_email($id){
    $email = Emails::find($id);
    $email->delete();
    return redirect('my_postmans');
  }

  public function enable_email($id){
    $email = Emails::find($id);
    $email->status = 0;
    $email->save();
    return redirect('my_postmans');
  }

  public function disable_email($id){
    $email = Emails::find($id);
    $email->status = 2;
    $email->save();
    return redirect('my_postmans');
  }

  public function send_all(Request $request){
    $recievers = explode("\n", $request->input('recievers'));
    foreach ($recievers as $reciever) {
      $available_postman = \DB::table('emails')->where('status', 0)->first();
      if ($available_postman) {
          // REMOVE for ON DEPLOYMENT
          for ($i=0; $i <50 ; $i++) {
            SendAll::dispatch($request->input('content'), trim($reciever));
          }

      }else{
        dump('ERROR NO AVAILABLE POSTMAN');
        break;
      }
    }
    //return view('test')->with('recievers', $recievers);
    //dd(Config::get('mail'));
    //dd($request->input('emails'));
    //dd($request->input('emails'));

    return redirect('/home');
  }
}
