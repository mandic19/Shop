<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VariantFactory extends Factory
{
    protected $model = Variant::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'handle' => Str::slug($this->faker->unique()->words(3, true)),
            'price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
