<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ActiviteSuggestion extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'activite_suggestions';

    protected $fillable = [
        'secteur',
        'activite',
    ];
}
