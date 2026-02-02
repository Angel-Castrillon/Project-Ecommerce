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
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Carrusel Musical',
                'price' => 45000,
                'stock' => 20,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Libro 1984',
                'price' => 28000,
                'stock' => 15,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],  
            [
                'name' => 'Set de Maquillaje',
                'price' => 65000,
                'stock' => 30,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Control Remoto',
                'price' => 35000,
                'stock' => 40,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Cortador de Vegetales',
                'price' => 22000,
                'stock' => 60,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Bolso Organizador',
                'price' => 48000,
                'stock' => 25,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Bolso Organizador Azul',
                'price' => 52000,
                'stock' => 10,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Juguete Pop It',
                'price' => 18000,
                'stock' => 100,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
            ],
            [
                'name' => 'Paquete de Bloques de Juguete',
                'price' => 25000,
                'stock' => 50,
                'image' => 'https://unsplash.com/es/fotos/e-FEipsPfiUvk'
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
                'category_id' => rand(1, 3),
                'image' => 'https://picsum.photos/seed/' . Str::slug($product['name']) . '/400/400',
            ]);
        }
    }
}
