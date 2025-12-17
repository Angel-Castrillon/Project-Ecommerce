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

        $query = Product::query();
 

        //Filtros
        if (array_key_exists('is_active', $validated)) {
            $query->where('is_active', $validated['is_active']);
        } else{
            $query->where('is_active', true);
        }

        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")->orWhere('sku', 'LIKE', "%{$search}%");
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
    }
}
