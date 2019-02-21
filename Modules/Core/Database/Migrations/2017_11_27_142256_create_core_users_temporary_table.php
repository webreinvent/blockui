<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreUsersTemporaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_users_temporary', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('country_calling_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->dateTime('email_sent_at')->nullable();
            $table->integer('resend_attempts')->nullable();
            $table->integer('verification_attempts')->nullable();
            $table->boolean('is_activated')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_users_temporary');
    }
}
