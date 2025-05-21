<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('main_contents', function (Blueprint $table) {
            $table->id();
            $table->string('start_video_link');
            $table->text('mission_description');
            $table->string('mission_image');
            $table->text('plan_description');
            $table->string('plan_image');
            $table->text('vision_description');
            $table->string('vision_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_contents');
    }
};
