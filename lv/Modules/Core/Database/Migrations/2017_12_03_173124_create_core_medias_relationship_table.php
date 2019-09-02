<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreMediasRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_medias_relationship', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('core_media_id')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('table_name')->nullable();
            $table->integer('table_id')->nullable();
            $table->integer('order')->nullable();
            $table->text('meta')->nullable();
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
        Schema::dropIfExists('core_medias_relationship');
    }
}
