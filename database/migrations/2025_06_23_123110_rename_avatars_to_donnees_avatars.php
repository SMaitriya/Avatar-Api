```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Renommer la table avatars en donnees_avatars
        Schema::rename('avatars', 'donnees_avatars');

        // Mettre à jour la contrainte de clé étrangère
        Schema::table('donnees_avatars', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte si elle existe
            try {
                $table->dropForeign('avatars_id_user_foreign');
            } catch (\Exception $e) {
                // Ignorer si la contrainte n'existe pas
            }
            // Ajouter la nouvelle contrainte
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Restaurer la contrainte avant de renommer
        Schema::table('donnees_avatars', function (Blueprint $table) {
            try {
                $table->dropForeign('donnees_avatars_id_user_foreign');
            } catch (\Exception $e) {
                // Ignorer si la contrainte n'existe pas
            }
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        // Renommer donnees_avatars en avatars
        Schema::rename('donnees_avatars', 'avatars');
    }
};
