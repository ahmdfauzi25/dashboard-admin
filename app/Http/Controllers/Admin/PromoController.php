<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Promo\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $banners = Promo::where('section', 'banner')->orderBy('position')->get();
        $flashsale = Promo::where('section', 'flashsale')->orderByDesc('id')->first();
        return view('admin.promos.index', compact('banners', 'flashsale'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image_url' => 'required|url',
            'link_url' => 'nullable|url',
            'section' => 'required|in:banner,flashsale,other',
            'ends_at' => 'nullable|date',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Promo::create($validated);

        return back()->with('status', 'Promo saved');
    }
}


