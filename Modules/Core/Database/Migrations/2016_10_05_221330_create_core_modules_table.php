<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_modules', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('name')->nullable();
	        $table->string('slug')->unique()->nullable();
	        $table->smallInteger('version_major')->nullable();
	        $table->smallInteger('version_minor')->nullable();
	        $table->smallInteger('version_revision')->nullable();
	        $table->smallInteger('version_build')->nullable();
	        $table->string('details')->nullable();
	        $table->text('meta')->nullable();
	        $table->string('enable')->nullable();
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
        Schema::dropIfExists('core_modules');
    }
}
