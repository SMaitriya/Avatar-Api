<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avatars', function (Blueprint $table) {
            // Supprimer id_user_1 si elle existe
            if (Schema::hasColumn('avatars', 'id_user_1')) {
                $table->dropColumn('id_user_1');
            }

            // Supprimer l'ancienne contrainte de clé étrangère si elle existe
            try {
                $table->dropForeign('avatars_id_user_foreign');
            } catch (\Exception $e) {
                // Ignorer si la contrainte n'existe pas
            }

            // Ajouter ou mettre à jour la contrainte de clé étrangère
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('avatars', function (Blueprint $table) {
            // Restaurer id_user_1 pour le rollback
            if (!Schema::hasColumn('avatars', 'id_user_1')) {
                $table->integer('id_user_1')->nullable();
            }

            // Supprimer la contrainte de clé étrangère
            try {
                $table->dropForeign('avatars_id_user_foreign');
            } catch (\Exception $e) {
                // Ignorer si la contrainte n'existe pas
            }
        });
    }
};
