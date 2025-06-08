<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop', 'description' => 'Laptop dan notebook'],
            ['name' => 'Desktop', 'description' => 'Komputer desktop'],
            ['name' => 'Server', 'description' => 'Server hardware'],
            ['name' => 'Network Equipment', 'description' => 'Router, switch, access point'],
            ['name' => 'Printer', 'description' => 'Printer dan scanner'],
            ['name' => 'Monitor', 'description' => 'Monitor dan display'],
            ['name' => 'Storage', 'description' => 'Hard disk, SSD, storage device'],
            ['name' => 'Mobile Device', 'description' => 'Smartphone, tablet'],
            ['name' => 'Accessories', 'description' => 'Keyboard, mouse, cable'],
            ['name' => 'Software License', 'description' => 'Software dan lisensi'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
