<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatbot_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chatbot_id')->constrained()->onDelete('cascade');
            $table->string('primary_color');
            $table->string('user_bubble');
            $table->string('bot_bubble');
            $table->string('user_text_color');
            $table->string('bot_text_color');
            $table->enum('position_x', ['left', 'right']);
            $table->enum('position_y', ['top', 'bottom']);
            $table->integer('offset_x');
            $table->integer('offset_y');
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
        Schema::dropIfExists('chatbot_preferences');
    }
};
