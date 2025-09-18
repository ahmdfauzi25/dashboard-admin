<?php

namespace App\Http\Controllers;

use App\Domains\Product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function index(Request $request)
	{
		$query = Product::query()->where('is_active', true);
		return response()->json($query->latest()->paginate(12));
	}

	public function show(Product $product)
	{
		abort_unless($product->is_active, 404);
		return response()->json($product);
	}
}


