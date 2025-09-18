<?php

namespace App\Http\Controllers\Api;

use App\Domains\Product\Product;
use App\Domains\JualAccount\JualAccount;
use App\Http\Controllers\Controller;
use App\Domains\Promo\Promo;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
	public function products(Request $request)
	{
		$products = Product::query()
			->where('is_active', true)
			->orderByDesc('id')
			->get(['id','name','image_url','price']);

		return response()->json($products);
	}

	public function jualAccounts(Request $request)
	{
		$accounts = JualAccount::query()
			->where('is_active', true)
			->orderByDesc('id')
			->get(['id','title','description','price']);

		return response()->json($accounts);
	}

	public function home(Request $request)
	{
		$banners = Promo::query()
			->where('section', 'banner')
			->where('is_active', true)
			->orderBy('position')
			->get(['id','title','image_url','link_url']);

		$flashsale = Promo::query()
			->where('section', 'flashsale')
			->where('is_active', true)
			->orderByDesc('id')
			->first(['ends_at']);

		return response()->json([
			'banners' => $banners,
			'flashsaleEndsAt' => optional($flashsale)->ends_at,
		]);
	}
}


