<?php

namespace App\Http\Controllers;

use App\Emails;
use App\Jobs\SendAll;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\KadastrTables;

class EmailsController extends Controller
{

  public function send_all(Request $request){
    //dd($request->input('content'));
    $validator = Validator::make($request->all(),[
      'content' => 'required',
      'recievers' => 'required',
      //'my_excel' => 'required'
    ]);

    if($validator->fails()){
      $response = $validator->messages();
      session()->flash('my_error', $response);
      return redirect('home');
    }

    /*try{
        Excel::load(Input::file('my_excel'), function ($reader) {
          dd($reader->toArray());
            foreach ($reader->toArray() as $row) {
                dump($row);
            }
        });
        dd('end');
        \Session::flash('success', 'Users uploaded successfully.');
        return redirect('home');
    }catch (\Exception $e){
        \Session::flash('error', $e->getMessage());
        return redirect('home');
    }*/

    $recievers = explode(",", $request->input('recievers'));
    $message = 'Сообщения загружены в очередь. ';
    $message .= 'Email-ы не прошедшие валидацию: ';
    foreach ($recievers as $reciever) {
      if(filter_var(trim($reciever), FILTER_VALIDATE_EMAIL)){
        $available_postman = \DB::table('emails')->where('status', 0)->first();
        if ($available_postman) {
            // REMOVE for ON DEPLOYMENT
            SendAll::dispatch($request->input('subject'), $request->input('content'), trim($reciever));
        }else{
          $message = 'ERROR NO AVAILABLE POSTMAN';
          break;
        }
      }else{
          $message .= trim($reciever).' ';
      }
    }
    //return view('test')->with('recievers', $recievers);
    //dd(Config::get('mail'));
    //dd($request->input('emails'));
    //dd($request->input('emails'));
    session()->flash('error', $message);
    return redirect('/home');
  }

  public function guest(Request $request){
    if (Auth::check()) {
      return redirect('/home');
    }
    return view('auth.login');
  }

  public function index(){
    $emails = Emails::all();
    return view('emails')->with('emails', $emails);
  }

  public function proxy(){
    $domains = \DB::table('domains')->paginate(15);
    return view('proxy')->with('domains', $domains);
  }

  public function parse1(){
    $kadastr_tables = \DB::table('kadastr_tables')->select('id', 'kadastr_number')->orderBy('id')->paginate(15);
    return view('parse1')->with('kadastr_tables', $kadastr_tables);
  }

  public function parse1delete(){
    $kadastr_tables = KadastrTables::select('id', 'kadastr_number', 'html')->take(500)->get();
    foreach ($kadastr_tables as $kadastr_table) {
      $check = 'Прослушивание на http://192.168.8.169:8001/aisgzk.kz/infoservice не выполняла ни одна конечная точка';
      $check = '20322041039';
      if (\strpos($kadastr_table->html, $check) != false) {
          $kadastr_table->delete();
      }
    }
    return redirect('parse1');
  }

  public function parse1page($id){
    $html = KadastrTables::select('html')->where('id', $id)->first();
    return view('parse1page')->with('html', $html);
  }

  public function hash(){
    return view('hash');
  }

  public function makehash(Request $request){
    $hash = \Hash::make($request['password']);
    return view('makehash')->with('hash', $hash);
  }

  public function my_queue(){
    $jobs = \DB::table('jobs')->paginate(25);
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
    $failed_jobs = \DB::table('failed_jobs')->paginate(20);
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
}
