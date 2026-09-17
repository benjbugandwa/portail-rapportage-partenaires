<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'date_publication',
        'doc_name',
        'file_path',
        'mime_type',
        'original_name',
        'doc_category',
        'uploaded_by',
        'doc_summary',
        'download_count',
    ];

    protected $casts = [
        'date_publication' => 'date',
        'download_count' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
