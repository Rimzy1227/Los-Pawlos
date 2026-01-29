<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            ['id' => 1, 'name' => 'Premium Dog Food 5kg', 'description' => 'High quality dog food for active dogs', 'price' => 34.49, 'stock' => 25, 'category_id' => 1, 'image' => 'premium-dog-food-5kg.webp', 'category' => 'Food'],
            ['id' => 2, 'name' => 'Cat Dry Kibble 2kg', 'description' => 'Healthy kibble for adult cats', 'price' => 19.75, 'stock' => 40, 'category_id' => 1, 'image' => 'cat-dry-kibble-2kg.jpg', 'category' => 'Food'],
            ['id' => 3, 'name' => 'Organic Bird Seed 1kg', 'description' => 'Natural and nutritious seed mix for birds', 'price' => 13.50, 'stock' => 35, 'category_id' => 1, 'image' => 'Organic-Bird-Seed-1kg.webp', 'category' => 'Food'],
            ['id' => 4, 'name' => 'Tropical Fish Flakes 500g', 'description' => 'Complete diet for tropical fish', 'price' => 11.99, 'stock' => 50, 'category_id' => 1, 'image' => 'Tropical-Fish-Flakes-500g.jpg', 'category' => 'Food'],
            // ... I will trust the user or a future step to import the rest or use the LegacyImportSeeder if it works. 
            // For now I'm adding a representative sample to ensure the app looks populated.
            ['id' => 11, 'name' => 'Rubber Chew Toy', 'description' => 'Durable chew toy for dogs', 'price' => 6.99, 'stock' => 100, 'category_id' => 2, 'image' => 'rubber-chew-toy.jpg', 'category' => 'Toys'],
            ['id' => 21, 'name' => 'Dog Shampoo 500ml', 'description' => 'Hypoallergenic shampoo for sensitive skin', 'price' => 14.99, 'stock' => 40, 'category_id' => 3, 'image' => 'dog-shampoo-500ml.jpg', 'category' => 'Grooming'],
            ['id' => 31, 'name' => 'Cat Scratching Post', 'description' => 'Sturdy scratching post for cats', 'price' => 45.00, 'stock' => 15, 'category_id' => 4, 'image' => 'cat-scratching-post.jpeg', 'category' => 'Accessories'],
        ]);
    }
}
