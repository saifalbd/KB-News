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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->text('text');
            $table->foreignId('parent_id')->nullable();
            $table->integer('react_count')->default(0);
            $table->bigInteger('commentable_id');
            $table->string('commentable_type');
            $table->timestamps();
        });

        Schema::create('comment_reacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            //->constrained('users');
            $table->foreignId('comment_id');
            //->constrained('comments')->cascadeOnDelete();
            $table->string('prop',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_reacts');
        Schema::dropIfExists('comments');
    }
};
