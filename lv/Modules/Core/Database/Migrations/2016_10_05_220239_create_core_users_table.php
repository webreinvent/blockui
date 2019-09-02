<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_users', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('name')->nullable();
	        $table->string('email')->unique();
	        $table->string('username', 20)->unique()->nullable();
	        $table->string('mobile')->nullable();
	        $table->string('password');
	        $table->integer('country_calling_code')->nullable();
	        $table->enum('gender', ["m", "f", "o"])->nullable();
	        $table->date('birth_date')->nullable();
	        $table->boolean('enable')->default(0);
	        $table->string('activation_code')->nullable();
	        $table->dateTime('activated_at')->nullable();
	        $table->dateTime('last_login')->nullable();
	        $table->ipAddress('last_login_ip')->nullable();
	        $table->rememberToken();
            $table->string('api_token',60)->unique()->nullable();
	        $table->integer('created_by')->nullable();
	        $table->integer('updated_by')->nullable();
	        $table->integer('deleted_by')->nullable();
	        $table->timestamps();
	        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_users');
    }
}
