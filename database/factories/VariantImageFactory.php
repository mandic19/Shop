<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Variant;
use App\Models\VariantImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantImageFactory extends Factory
{
    protected $model = VariantImage::class;

    public function definition(): array
    {
        return [
            'variant_id' => Variant::factory(),
            'image_id' => Image::factory(),
            'position' => $this->faker->numberBetween(1, 10),
        ];
    }
}
