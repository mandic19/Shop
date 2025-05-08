<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'handle',
        'price',
        'image_id',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
