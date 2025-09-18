<?php

namespace App\Http\Controllers\Admin;

use App\Domains\JualAccount\JualAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
	public function index()
	{
		$accounts = JualAccount::orderByDesc('id')->paginate(15);
		return view('livewire.admin.accounts.index', compact('accounts'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'title' => 'required|string|max:255',
			'description' => 'nullable|string',
			'price' => 'nullable|integer|min:0',
			'is_active' => 'nullable|boolean',
		]);

		$validated['is_active'] = $request->boolean('is_active', true);
		JualAccount::create($validated);

		return back()->with('status', 'Account created');
	}
}


