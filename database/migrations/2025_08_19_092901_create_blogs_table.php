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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');                         // Blog title
            $table->string('slug')->unique();                // SEO-friendly URL
            $table->longText('content');                     // Main content
            $table->string('image')->nullable();             // Featured image
            $table->string('author')->nullable();            // Correct spelling :)
            $table->string('meta_title')->nullable();        // SEO meta title
            $table->text('meta_description')->nullable();    // SEO meta description
            $table->string('meta_keywords')->nullable();     // SEO keywords (comma separated)
            $table->boolean('status')->default(1);           // Active/inactive
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
        Schema::dropIfExists('blogs');
    }
};
