<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::create([
            'name' => 'Tecnología',
            'slug' => 'tecnologia',
            'description' => 'Dispositivos electrónicos y más.'
        ]);

        \App\Models\Category::create([
            'name' => 'Hogar',
            'slug' => 'hogar',
            'description' => 'Productos para el hogar.'
        ]);
        
        \App\Models\Category::create([
            'name' => 'Juguetes',
            'slug' => 'juguetes',
            'description' => 'Diversión para todos.'
        ]);
    }
}
