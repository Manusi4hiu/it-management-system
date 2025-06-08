<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $categories = Category::all();

        $sampleItems = [
            [
                'name' => 'Dell Latitude 7420',
                'brand' => 'Dell',
                'model' => 'Latitude 7420',
                'category' => 'Laptop',
                'status' => 'in_use',
                'assigned_to' => 'John Doe'
            ],
            [
                'name' => 'HP ProDesk 400 G7',
                'brand' => 'HP',
                'model' => 'ProDesk 400 G7',
                'category' => 'Desktop',
                'status' => 'available'
            ],
            [
                'name' => 'Cisco Catalyst 2960',
                'brand' => 'Cisco',
                'model' => 'Catalyst 2960-24TT-L',
                'category' => 'Network Equipment',
                'status' => 'in_use',
                'location' => 'Server Room'
            ],
            [
                'name' => 'Canon imageRUNNER 2625i',
                'brand' => 'Canon',
                'model' => 'imageRUNNER 2625i',
                'category' => 'Printer',
                'status' => 'available',
                'location' => 'Office Floor 2'
            ],
            [
                'name' => 'Dell PowerEdge R740',
                'brand' => 'Dell',
                'model' => 'PowerEdge R740',
                'category' => 'Server',
                'status' => 'in_use',
                'location' => 'Data Center'
            ]
        ];

        foreach ($sampleItems as $item) {
            $category = $categories->where('name', $item['category'])->first();

            InventoryItem::create([
                'name' => $item['name'],
                'brand' => $item['brand'],
                'model' => $item['model'],
                'serial_number' => strtoupper($faker->bothify('??########')),
                'category_id' => $category->id,
                'status' => $item['status'],
                'location' => $item['location'] ?? $faker->randomElement(['Office Floor 1', 'Office Floor 2', 'Server Room', 'Warehouse']),
                'description' => $faker->sentence(),
                'purchase_price' => $faker->randomFloat(2, 500, 50000),
                'purchase_date' => $faker->dateTimeBetween('-2 years', 'now'),
                'warranty_expiry' => $faker->dateTimeBetween('now', '+3 years'),
                'assigned_to' => $item['assigned_to'] ?? ($item['status'] === 'in_use' ? $faker->name() : null),
            ]);
        }

        // Generate additional random items
        for ($i = 0; $i < 50; $i++) {
            $category = $categories->random();
            $status = $faker->randomElement(['available', 'in_use', 'maintenance', 'retired']);

            InventoryItem::create([
                'name' => $faker->company() . ' ' . $faker->word(),
                'brand' => $faker->randomElement(['Dell', 'HP', 'Lenovo', 'Asus', 'Acer', 'Apple', 'Cisco', 'Canon', 'Epson']),
                'model' => strtoupper($faker->bothify('??-####')),
                'serial_number' => strtoupper($faker->bothify('??########')),
                'category_id' => $category->id,
                'status' => $status,
                'location' => $faker->randomElement(['Office Floor 1', 'Office Floor 2', 'Server Room', 'Warehouse', 'Storage']),
                'description' => $faker->sentence(),
                'purchase_price' => $faker->randomFloat(2, 100, 25000),
                'purchase_date' => $faker->dateTimeBetween('-3 years', 'now'),
                'warranty_expiry' => $faker->dateTimeBetween('now', '+2 years'),
                'assigned_to' => $status === 'in_use' ? $faker->name() : null,
            ]);
        }
    }
}
