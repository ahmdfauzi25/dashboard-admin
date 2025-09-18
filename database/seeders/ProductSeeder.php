<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Product\Product;

class ProductSeeder extends Seeder
{
	public function run(): void
	{
		$catalog = [
			[
				'game' => 'Mobile Legends', 'slug' => 'mobile-legends', 'unit' => 'Diamonds',
				'denoms' => [86 => 25000, 172 => 48000, 257 => 72000, 344 => 96000]
			],
			[
				'game' => 'Free Fire', 'slug' => 'free-fire', 'unit' => 'Diamonds',
				'denoms' => [140 => 28000, 355 => 68000, 720 => 129000]
			],
			[
				'game' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'unit' => 'UC',
				'denoms' => [60 => 15000, 325 => 75000, 660 => 149000]
			],
			[
				'game' => 'Genshin Impact', 'slug' => 'genshin-impact', 'unit' => 'Genesis Crystal',
				'denoms' => [60 => 15000, 300 => 73000, 980 => 229000]
			],
			[
				'game' => 'Honkai Star Rail', 'slug' => 'honkai-star-rail', 'unit' => 'Oneiric Shard',
				'denoms' => [60 => 15000, 300 => 73000, 980 => 229000]
			],
			[
				'game' => 'VALORANT', 'slug' => 'valorant', 'unit' => 'Points',
				'denoms' => [125 => 15000, 420 => 50000, 700 => 80000]
			],
			[
				'game' => 'Call of Duty Mobile', 'slug' => 'codm', 'unit' => 'CP',
				'denoms' => [80 => 15000, 420 => 75000, 880 => 149000]
			],
			[
				'game' => 'Roblox', 'slug' => 'roblox', 'unit' => 'Robux',
				'denoms' => [80 => 15000, 400 => 75000, 800 => 149000]
			],
			[
				'game' => 'League of Legends: Wild Rift', 'slug' => 'wild-rift', 'unit' => 'Wild Cores',
				'denoms' => [200 => 30000, 500 => 70000, 1000 => 135000]
			],
			[
				'game' => 'Point Blank', 'slug' => 'point-blank', 'unit' => 'Cash',
				'denoms' => [1200 => 20000, 2400 => 38000, 6000 => 90000]
			],
			[
				'game' => 'Steam Wallet ID', 'slug' => 'steam-wallet', 'unit' => 'Voucher',
				'denoms' => [12000 => 15000, 45000 => 52000, 90000 => 102000]
			],
			[
				'game' => 'Garena Shells', 'slug' => 'garena-shells', 'unit' => 'Shell',
				'denoms' => [33 => 10000, 66 => 19000, 165 => 45000]
			],
			[
				'game' => 'Google Play', 'slug' => 'google-play', 'unit' => 'Voucher',
				'denoms' => [50000 => 54000, 100000 => 104000, 200000 => 204000]
			],
		];

		foreach ($catalog as $entry) {
			$baseImage = 'https://picsum.photos/seed/'.$entry['slug'].'/640/360';
			foreach ($entry['denoms'] as $amount => $price) {
				$name = $entry['game'].' '.$entry['unit'].' '.$amount;
				Product::updateOrCreate(
					['name' => $name],
					[
						'name' => $name,
						'image_url' => $baseImage,
						'price' => $price,
						'is_active' => true,
					]
				);
			}
		}
	}
}


