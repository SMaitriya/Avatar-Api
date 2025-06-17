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
        Schema::create('avatars', function (Blueprint $table) {

        $table->id('id_avatar'); 
        $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
        $table->string('name', 50);
        $table->string('nose_size', 50);
        $table->string('eye_type', 50)->nullable();
        $table->string('eye_color', 50);
        $table->string('eye_size', 50);
        $table->string('eyebrow_type', 50);
        $table->string('eyebrow_color', 50);
        $table->string('hair_type', 50);
        $table->string('hair_color', 50);
        $table->string('mouth_type', 50)->nullable();
        $table->string('mouth_size', 50);
        $table->string('beard_type', 50);
        $table->string('beard_color', 50)->nullable();
        $table->string('shirt_color', 50);
        $table->string('glasses_type', 50)->nullable();
        $table->string('accessory_type', 50)->nullable();
        $table->string('background_type', 50)->nullable();
        $table->string('skin_color', 50);
        $table->string('nose_type', 50);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
