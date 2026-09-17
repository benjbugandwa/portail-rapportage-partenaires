<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activite extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'intitule',
        'date_activite',
        'secteur_id',
        'population_cible',
        'description',
        'defis_contraintes',
        'localites',
        'province_id',
        'nbre_personnes',
        'nbre_menage',
        'file_path',
        'statut',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date_activite' => 'date',
            'population_cible' => 'array',
            'province_id' => 'array',
        ];
    }

    public function secteur(): BelongsTo
    {
        return $this->belongsTo(Secteur::class);
    }

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
