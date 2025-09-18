<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\JualAccount\JualAccount;

class AccountSeeder extends Seeder
{
	public function run(): void
	{
		$items = [
			['title' => 'Akun MLBB Mythic, skin banyak', 'description' => 'Level 30+, banyak skin epic', 'price' => 150000],
			['title' => 'Akun FF Sultan', 'description' => 'Bundle langka, rank diamond', 'price' => 200000],
			['title' => 'Akun Genshin AR45', 'description' => 'Beberapa 5* awal, story lanjut', 'price' => 900000],
		];

		foreach ($items as $data) {
			JualAccount::updateOrCreate(
				['title' => $data['title']],
				$data + ['is_active' => true]
			);
		}
	}
}


