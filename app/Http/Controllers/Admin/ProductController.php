<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Product\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function index()
	{
		$products = Product::orderByDesc('id')->paginate(15);
		return view('livewire.admin.products.index', compact('products'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'image_url' => 'nullable|url',
			'price' => 'required|integer|min:0',
			'is_active' => 'nullable|boolean',
		]);

		$validated['is_active'] = $request->boolean('is_active', true);
		Product::create($validated);

		return back()->with('status', 'Product created');
	}
}


