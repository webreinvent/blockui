<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreSmsAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_sms_alerts', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('type')->nullable();
	        $table->string('label')->nullable();
	        $table->integer('core_user_id')->nullable();
	        $table->string('to')->nullable();
	        $table->text('message')->nullable();
	        $table->text('meta')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('sent_at')->nullable();
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
        Schema::dropIfExists('core_sms_alerts');
    }
}
