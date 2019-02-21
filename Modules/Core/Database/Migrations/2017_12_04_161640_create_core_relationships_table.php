<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_relationships', function (Blueprint $table) {
            $table->increments('id');

            $table->string('source_table_name')->nullable();
            $table->integer('source_table_id')->nullable();

            $table->string('destination_table_name')->nullable();
            $table->integer('destination_table_id')->nullable();

            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('label')->nullable();
            $table->text('meta')->nullable();

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
        Schema::dropIfExists('core_relationships');
    }
}
