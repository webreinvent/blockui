<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_activities', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('type')->nullable();
	        $table->string('label')->nullable();
            $table->string('action')->nullable();
	        $table->string('title')->nullable();
	        $table->text('meta')->nullable();
	        $table->string('table_name')->nullable();
	        $table->integer('table_id')->nullable();
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
        Schema::dropIfExists('core_activities');
    }
}
