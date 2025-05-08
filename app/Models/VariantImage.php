<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantImage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'variant_id',
        'image_id',
        'position',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
