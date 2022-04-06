<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReytingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reytings', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->integer('ball');
            $table->unsignedBigInteger('messages_id');
            $table->timestamps();
            $table->foreign("messages_id")->references("id")->on("messages")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reytings');
    }
}
