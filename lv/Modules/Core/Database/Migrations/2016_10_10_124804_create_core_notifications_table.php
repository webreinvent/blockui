<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_notifications', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('type')->nullable();
	        $table->string('label')->nullable();
	        $table->integer('core_user_id')->nullable();
	        $table->string('table_name')->nullable();
	        $table->integer('table_id')->nullable();
	        $table->string('title')->nullable();
	        $table->string('details')->nullable();
	        $table->string('link')->nullable();
	        $table->text('meta')->nullable();
            $table->string('status')->nullable();
	        $table->dateTime('sent_at')->nullable();
	        $table->dateTime('read_at')->nullable();
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
        Schema::dropIfExists('core_notifications');
    }
}
