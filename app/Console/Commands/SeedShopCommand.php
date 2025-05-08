<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\ShopSeeder;

class SeedShopCommand extends Command
{
    protected $signature = 'db:seed:shop
                            {--products=10 : Number of products to generate}
                            {--variants=3 : Number of variants per product}
                            {--product-images=1 : Number of images per product}
                            {--variant-images=2 : Number of images per variant}';

    protected $description = 'Seed the shop database with configurable number of products, variants, and images';

    public function handle()
    {
        $products = (int) $this->option('products');
        $variants = (int) $this->option('variants');
        $productImages = (int) $this->option('product-images');
        $variantImages = (int) $this->option('variant-images');

        $this->components->info("Seeding shop data...");
        $this->components->info("Products: {$products}, Variants per product: {$variants}, Product Images per product: {$productImages}, Variant Images per variant: {$variantImages}");

        $seeder = new ShopSeeder();
        $seeder->run($products, $variants, $productImages, $variantImages);

        $this->components->success("Shop data seeded successfully!");
    }
}
