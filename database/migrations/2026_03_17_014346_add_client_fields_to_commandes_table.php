<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('nom_client')->nullable()->after('user_id');
            $table->string('prenom_client')->nullable()->after('nom_client');
            $table->string('email_client')->nullable()->after('prenom_client');
            $table->string('adresse_livraison')->nullable()->after('email_client');
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn(['nom_client', 'prenom_client', 'email_client', 'adresse_livraison']);
        });
    }
};
