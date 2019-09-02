<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_permissions', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('name');
	        $table->string('slug')->unique();
	        $table->string('prefix')->nullable();
	        $table->string('details')->nullable();
	        $table->boolean('enable')->default(0);
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
        Schema::dropIfExists('core_permissions');
    }
}
