<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantImage;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(
        int $productCount = 10,
        int $variantsPerProduct = 3,
        int $productImagesPerProduct = 1,
        int $imagesPerVariant = 2
    ): void {
        // Clear existing data
        VariantImage::query()->delete();
        Variant::query()->delete();
        Product::query()->delete();
        Image::query()->delete();

        $productImagesPerProduct = min($productImagesPerProduct, 1);

        // Create products
        $productFactory = Product::factory($productCount);

        // Conditionally add images based on $productImagesPerProduct
        $productFactory = $productImagesPerProduct > 0
            ? $productFactory->withImage()
            : $productFactory->withoutImage();

        $productFactory->create()
            ->each(function (Product $product) use ($variantsPerProduct, $imagesPerVariant) {
                // Ensure variants do not exceed 2,000 per product
                $variantsPerProduct = min($variantsPerProduct, 2000);
                Variant::factory($variantsPerProduct)
                    ->create(['product_id' => $product->id])
                    ->each(function (Variant $variant) use ($imagesPerVariant) {
                        // Limit to 20 images per variant
                        $imagesPerVariant = min($imagesPerVariant, 20);
                        VariantImage::factory($imagesPerVariant)
                            ->create(['variant_id' => $variant->id]);
                    });
            });
    }
}
