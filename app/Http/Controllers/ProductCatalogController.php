<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ProductCatalogController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validación de entrada
            $validated = $request->validate([
                'search'      => ['nullable', 'string', 'max:180'],
                'category_id' => ['nullable', 'integer'],
                'min_price'   => ['nullable', 'numeric', 'min:0'],
                'max_price'   => ['nullable', 'numeric', 'min:0'],
                'in_stock'    => ['nullable', 'boolean'],
                'is_active'   => ['nullable', 'boolean'],

                'sort_by'     => ['nullable', Rule::in(['id', 'created_at', 'price', 'name'])],
                'sort_dir'    => ['nullable', Rule::in(['asc', 'desc'])],

                'per_page'    => ['nullable', 'integer', 'min:1', 'max:50'],
            ]);

            $query = Product::with('category');
    

            //Filtros
            if (isset($validated['is_active'])) {
                $query->where('is_active', $validated['is_active']);
            } else {
                $query->where('is_active', true);
            }

            if (!empty($validated['search'])) {
                $search = strtolower($validated['search']);
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                      ->orWhereRaw('LOWER(sku) LIKE ?', ["%{$search}%"]);
                });
            }

            if (!empty($validated['category_id'])) {
                $query->where('category_id', $validated['category_id']);
            }

            if (!empty($validated['min_price'])) {
                $query->where('price', '>=', $validated['min_price']);
            }

            if (!empty($validated['max_price'])) {
                $query->where('price', '<=', $validated['max_price']);
            }

            if (!empty($validated['in_stock'])) {
                $query->where('stock', '>', 0);
            }

            //Ordenamiento
            $sortBy  = $validated['sort_by']  ?? 'id';
            $sortDir = $validated['sort_dir'] ?? 'asc';

            $query->orderBy($sortBy, $sortDir);

            if ($sortBy !== 'id') {
                $query->orderBy('id', $sortDir);
            }

            //Paginación por CURSOR
            $perPage = $validated['per_page'] ?? 10;

            $products = $query->cursorPaginate($perPage);

            return response()->json($products);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'Los datos proporcionados no son válidos',
                    'details' => $e->errors()
                ]
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'CATALOG_ERROR',
                    'message' => 'Error al obtener el catálogo de productos',
                    'details' => [
                        'error' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor'
                    ]
                ]
            ], 500);
        }
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'PRODUCT_NOT_FOUND',
                    'message' => 'Producto no encontrado',
                    'details' => [
                        'id' => $id
                    ]
                ]
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }
}
