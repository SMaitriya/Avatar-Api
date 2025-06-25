<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvatarCompletTable extends Migration
{
    public function up()
    {
        Schema::create('avatar_complet', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->uuid('avatar_id')->unique(); // UUID unique pour chaque avatar
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clé étrangère vers users.id
            $table->text('avatar_svg'); // Contenu SVG complet
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('avatar_complet');
    }
}