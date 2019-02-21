<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_comment_id')->nullable();
            $table->integer('counter')->nullable();
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->string('type')->nullable();
            $table->string('table_name')->nullable();
            $table->integer('table_id')->nullable();
            $table->boolean('private')->nullable();
            $table->text('meta')->nullable();

            $table->dateTime('sent_at')->nullable();

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
        Schema::dropIfExists('core_comments');
    }
}
