<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('intitule');
            $table->date('date_activite');
            $table->foreignUuid('secteur_id')->constrained()->cascadeOnDelete();
            $table->json('population_cible')->nullable();
            $table->text('description')->nullable();
            $table->text('defis_contraintes')->nullable();
            $table->text('localites')->nullable();
            $table->json('province_id')->nullable();
            $table->integer('nbre_personnes')->nullable()->default(0);
            $table->integer('nbre_menage')->nullable()->default(0);
            $table->string('file_path')->nullable();
            $table->string('statut')->default('en cours');
            $table->foreignUuid('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activites');
    }
};
