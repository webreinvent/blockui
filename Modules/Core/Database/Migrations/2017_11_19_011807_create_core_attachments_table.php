<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->nullable();
            $table->string('file_url')->nullable();
            $table->string('type')->nullable();
            $table->string('table_name')->nullable();
            $table->integer('table_id')->nullable();
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
        Schema::dropIfExists('core_attachments');
    }
}
