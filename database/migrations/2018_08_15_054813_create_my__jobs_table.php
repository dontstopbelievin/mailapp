<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('all_today_attempts');
            $table->integer('all_total_attempts');
            $table->timestamps();
        });

        Schema::table('my_jobs', function (Blueprint $table) {
            //
            DB::table('my_jobs')->insert([
                [
                    'all_today_attempts' => '0',
                    'all_total_attempts' => '0',
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
        Schema::dropIfExists('my__jobs');
    }
}
