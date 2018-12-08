<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuiBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bui_blocks', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();

            $table->string('slug')->nullable();

            $table->string('iframe_url')->nullable();

            $table->string('thumbnail_url')->nullable();

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->integer('bui_framework_id')->nullable();
            $table->integer('bui_theme_id')->nullable();
            $table->integer('bui_trend_id')->nullable();
            $table->integer('bui_section_id')->nullable();
            $table->integer('bui_component_id')->nullable();


            $table->text('css')->nullable();
            $table->text('html')->nullable();
            $table->text('js')->nullable();

            $table->text('page_html')->nullable();

            $table->text('meta')->nullable();


            $table->string('status')->nullable();
            $table->integer('block_count')->nullable();
            $table->integer('view_count')->nullable();
            $table->integer('download_count')->nullable();

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
        Schema::dropIfExists('bui_blocks');
    }
}
