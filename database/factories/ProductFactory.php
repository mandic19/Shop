<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);

        return [
            'title' => ucwords($title),
            'handle' => Str::slug($title),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'image_id' => null,
        ];
    }

    public function withImage(): ProductFactory
    {
        return $this->state(function () {
            return [
                'image_id' => Image::factory(),
            ];
        });
    }

    public function withoutImage(): ProductFactory
    {
        return $this->state(function () {
            return [
                'image_id' => null,
            ];
        });
    }
}
