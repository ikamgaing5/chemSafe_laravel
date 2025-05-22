<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('usine_id');
            $table->string('name');
            $table->string('username', 191)->unique();
            $table->string('password');
            $table->string('role');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username', 191)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        schema::create('produit', function (Blueprint $table) {
            $table->id();
            $table->string('nomprod');
            $table->string('type_emballage');
            $table->string('poids');
            $table->string('nature');
            $table->string('utilisation');
            $table->string('fabricant');
            $table->string('photo');
            $table->string('fds');
            $table->string('risque');
        });

        schema::create('usine', function (Blueprint $table) {
            $table->id();
            $table->string('nomusine');
            $table->string('active')->default("true");
        });

        schema::create('danger', function (Blueprint $table) {
            $table->id();
            $table->string('nomdanger');
        });

        schema::create('historique_acces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('created_at');
            $table->time('time');
            $table->string('action');
        });

        Schema::create('infofds', function (Blueprint $table) {
            $table->id();
            $table->string('produit_id');
            $table->string('physique');
            $table->string('sante');
            $table->string('ppt');
            $table->string('stabilite');
            $table->string('eviter');
            $table->string('incompatible');
            $table->string('reactivite');
            $table->string('stockage');
            $table->string('secours');
            $table->string('epi');
        });

        schema::create('atelier', function (Blueprint $table) {
            $table->id();
            $table->string('usine_id');
            $table->string('nomatelier');
            $table->string('active')->default(true);
        });

        schema::create('historique', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('produit_id');
            $table->string('atelier_id');
            $table->string('usine_id');
            $table->string('action');
            $table->timestamp('created_at');
            $table->string('created_by');
        });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};