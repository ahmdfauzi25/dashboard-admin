<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		if (Schema::hasTable('accounts') && !Schema::hasTable('jual_accounts')) {
			Schema::rename('accounts', 'jual_accounts');
		}
	}

	public function down(): void
	{
		if (Schema::hasTable('jual_accounts') && !Schema::hasTable('accounts')) {
			Schema::rename('jual_accounts', 'accounts');
		}
	}
};


