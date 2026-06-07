<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Channel;
use App\Models\Wallet;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@local.test'],
            ['name' => 'Admin', 'password' => null, 'role' => 'admin']
        );

        Wallet::firstOrCreate(['user_id' => $admin->id], ['cash_balance' => 1000, 'bonus_balance' => 0, 'currency' => 'USD']);

        Channel::firstOrCreate(['name' => 'Telegram'], ['type' => 'telegram', 'is_active' => true, 'config' => ['chat_id' => env('TELEGRAM_CHAT_ID')]]);
    }
}
