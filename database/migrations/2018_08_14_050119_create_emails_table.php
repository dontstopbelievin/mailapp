<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->integer('mails_today');
            $table->integer('mails_total');
            $table->integer('attempts_today');
            $table->integer('attempts_total');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::table('emails', function (Blueprint $table) {
            //
            DB::table('emails')->insert([
                [
                    'email' => 'sendmailapp01@gmail.com',
                    'password' => '123123Aa',
                    'mails_today' => '0',
                    'mails_total' => '0',
                    'attempts_today' => '0',
                    'attempts_total' => '0',
                    'status' => '0'
                ]
            ]);
            DB::table('emails')->insert([
                [
                    'email' => 'ssending6@gmail.com',
                    'password' => '123123Aa',
                    'mails_today' => '0',
                    'mails_total' => '0',
                    'attempts_today' => '0',
                    'attempts_total' => '0',
                    'status' => '0'
                ]
            ]);
            DB::table('emails')->insert([
                [
                    'email' => 'sendmailapp02@gmail.com',
                    'password' => '123123Aa',
                    'mails_today' => '0',
                    'mails_total' => '0',
                    'attempts_today' => '0',
                    'attempts_total' => '0',
                    'status' => '0'
                ]
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
