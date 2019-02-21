<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_reactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emoji')->nullable();
            $table->string('text')->nullable();

            $table->string('table_name')->nullable();
            $table->integer('table_id')->nullable();
            $table->text('meta')->nullable();

            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('core_reactions');
    }
}
