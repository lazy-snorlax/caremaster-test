<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    public function run() {
        $user = User::where('email', 'user@codium.com.au')->first();
        $orgAdmin = User::where('email', 'orgadmin@codium.com.au')->first();
        $admin = User::where('email', 'admin@codium.com.au')->first();
    }
}