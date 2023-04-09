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
     
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id');
            $table->string('title');
            $table->string('slug');
            $table->foreignId('avatar_id');
            $table->text('body');
            $table->text('description')->nullable();
            $table->boolean('publish')->default(false);
            $table->boolean('on_feature')->default(false);
            $table->boolean('on_home_top')->default(false);
            $table->boolean('on_popular')->default(false);
            $table->boolean('on_trending')->default(false);
            $table->boolean('show_author')->default(false);

            $table->timestamps();
        });

        Schema::create('post-category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->foreignId('category_id');
        });

        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->ipAddress();
            $table->timestamps();
        });



        Schema::create('post-attachment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->foreignId('attachment_id');
            
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_views');
        Schema::dropIfExists('post-category');
        Schema::dropIfExists('post-attachment');
        Schema::dropIfExists('posts');
    }
};
