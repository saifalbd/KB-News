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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('disk');
            $table->string('path');
            $table->string('sm_path');
            $table->string('md_path');
            $table->string('model')->nullable();
            $table->timestamps();
        });

        Schema::create('attachales', function (Blueprint $table) {
            $table->foreignId('attachment_id');
            $table->bigInteger('attachale_id');
            $table->string('attachale_type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('avatar_id')->nullable()->after('password');
            //->constrained('attachments');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::dropIfExists('users');
        Schema::dropIfExists('attachales');
        Schema::dropIfExists('attachments');
    }
};
