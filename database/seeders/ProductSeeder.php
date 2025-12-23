<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Espinaca',
                'price' => 12000,
                'stock' => 50,
                'image' => 'https://via.placeholder.com/200x200/90EE90/000000?text=Espinaca'
            ],
            [
                'name' => 'Carrusel Musical',
                'price' => 45000,
                'stock' => 20,
                'image' => 'https://via.placeholder.com/200x200/FFB6C1/000000?text=Carrusel'
            ],
            [
                'name' => 'Libro 1984',
                'price' => 28000,
                'stock' => 15,
                'image' => 'https://via.placeholder.com/200x200/87CEEB/000000?text=1984'
            ],
            [
                'name' => 'Set de Maquillaje',
                'price' => 65000,
                'stock' => 30,
                'image' => 'https://via.placeholder.com/200x200/FFD700/000000?text=Makeup'
            ],
            [
                'name' => 'Control Remoto',
                'price' => 35000,
                'stock' => 40,
                'image' => 'https://via.placeholder.com/200x200/DDA0DD/000000?text=Control'
            ],
            [
                'name' => 'Cortador de Vegetales',
                'price' => 22000,
                'stock' => 60,
                'image' => 'https://via.placeholder.com/200x200/98FB98/000000?text=Cortador'
            ],
            [
                'name' => 'Bolso Organizador',
                'price' => 48000,
                'stock' => 25,
                'image' => 'https://via.placeholder.com/200x200/778899/000000?text=Bolso'
            ],
            [
                'name' => 'Bolso Organizador Azul',
                'price' => 52000,
                'stock' => 10,
                'image' => 'https://via.placeholder.com/200x200/4682B4/000000?text=Bolso'
            ],
            [
                'name' => 'Juguete Pop It',
                'price' => 18000,
                'stock' => 100,
                'image' => 'https://via.placeholder.com/200x200/DA70D6/000000?text=PopIt'
            ],
            [
                'name' => 'Paquete de Bloques de Juguete',
                'price' => 25000,
                'stock' => 50,
                'image' => 'https://via.placeholder.com/200x200/DA70D6/000000?text=Paquete'
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'sku' => strtoupper(Str::random(8)),
                'description' => 'Descripción de prueba para ' . $product['name'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'is_active' => true,
            ]);
        }
    }
}
