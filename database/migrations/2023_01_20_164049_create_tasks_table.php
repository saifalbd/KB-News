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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('employee_id')->constrained('users');
            $table->string('title');
            $table->date('start');
            $table->date('end');
            $table->tinyInteger('status')->default(0);
            $table->longText('description')->nullable();
            $table->boolean('user_star')->default(0);
            $table->boolean('employee_star')->default(0);
            $table->boolean('user_archive')->default(0);
            $table->boolean('employee_archive')->default(0);
            $table->softDeletes();
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
    
        Schema::dropIfExists('tasks');
    }
};
