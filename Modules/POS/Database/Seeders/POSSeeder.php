<?php

namespace Modules\POS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\POS\App\Entities\Category;
use Modules\POS\App\Entities\Product;

class POSSeeder extends Seeder
{
    public function run(): void
    {
        // 5 categories
        $categories = [
            ['name' => 'Beverages',    'description' => 'Hot and cold drinks'],
            ['name' => 'Snacks',       'description' => 'Light snacks and crisps'],
            ['name' => 'Electronics',  'description' => 'Electronic accessories'],
            ['name' => 'Stationery',   'description' => 'Office and school supplies'],
            ['name' => 'Groceries',    'description' => 'Daily grocery items'],
        ];

        $categoryIds = [];
        foreach ($categories as $data) {
            $cat = Category::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                ['name' => $data['name'], 'description' => $data['description'], 'is_active' => true]
            );
            $categoryIds[$data['name']] = $cat->id;
        }

        // 20 products (4 per category)
        $products = [
            // Beverages
            ['name'=>'Mineral Water 500ml',  'category'=>'Beverages',   'purchase'=>8,    'sale'=>15,   'stock'=>150],
            ['name'=>'Orange Juice 1L',      'category'=>'Beverages',   'purchase'=>45,   'sale'=>75,   'stock'=>80],
            ['name'=>'Green Tea Pack',       'category'=>'Beverages',   'purchase'=>60,   'sale'=>100,  'stock'=>60],
            ['name'=>'Energy Drink 250ml',   'category'=>'Beverages',   'purchase'=>30,   'sale'=>55,   'stock'=>100],
            // Snacks
            ['name'=>'Potato Chips 100g',    'category'=>'Snacks',      'purchase'=>20,   'sale'=>35,   'stock'=>200],
            ['name'=>'Chocolate Bar',        'category'=>'Snacks',      'purchase'=>15,   'sale'=>30,   'stock'=>180],
            ['name'=>'Biscuit Pack',         'category'=>'Snacks',      'purchase'=>25,   'sale'=>45,   'stock'=>120],
            ['name'=>'Popcorn 80g',          'category'=>'Snacks',      'purchase'=>18,   'sale'=>32,   'stock'=>90],
            // Electronics
            ['name'=>'USB Cable Type-C',     'category'=>'Electronics', 'purchase'=>50,   'sale'=>120,  'stock'=>75],
            ['name'=>'Phone Charger 20W',    'category'=>'Electronics', 'purchase'=>180,  'sale'=>350,  'stock'=>40],
            ['name'=>'Earphones Wired',      'category'=>'Electronics', 'purchase'=>120,  'sale'=>250,  'stock'=>55],
            ['name'=>'Screen Protector',     'category'=>'Electronics', 'purchase'=>30,   'sale'=>80,   'stock'=>100],
            // Stationery
            ['name'=>'Ball Pen (Pack of 5)', 'category'=>'Stationery',  'purchase'=>20,   'sale'=>40,   'stock'=>300],
            ['name'=>'A4 Notebook 100pg',    'category'=>'Stationery',  'purchase'=>35,   'sale'=>65,   'stock'=>200],
            ['name'=>'Highlighter Set',      'category'=>'Stationery',  'purchase'=>40,   'sale'=>75,   'stock'=>80],
            ['name'=>'Sticky Notes',         'category'=>'Stationery',  'purchase'=>25,   'sale'=>50,   'stock'=>150],
            // Groceries
            ['name'=>'Rice 1kg',             'category'=>'Groceries',   'purchase'=>55,   'sale'=>80,   'stock'=>500],
            ['name'=>'Sugar 1kg',            'category'=>'Groceries',   'purchase'=>60,   'sale'=>90,   'stock'=>400],
            ['name'=>'Cooking Oil 1L',       'category'=>'Groceries',   'purchase'=>110,  'sale'=>150,  'stock'=>200],
            ['name'=>'Salt 500g',            'category'=>'Groceries',   'purchase'=>15,   'sale'=>25,   'stock'=>350],
        ];

        foreach ($products as $data) {
            $sku = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $data['name']), 0, 3))
                 . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

            Product::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'category_id'    => $categoryIds[$data['category']],
                    'name'           => $data['name'],
                    'sku'            => $sku,
                    'purchase_price' => $data['purchase'],
                    'sale_price'     => $data['sale'],
                    'stock'          => $data['stock'],
                    'alert_quantity' => 10,
                    'unit'           => 'pcs',
                    'type'           => 'standard',
                    'is_active'      => true,
                ]
            );
        }

        $this->command->info('POS seeded: 5 categories, 20 products.');
    }
}
