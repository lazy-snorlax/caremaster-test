<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\LocalSeeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('abilities:refresh');

        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.io',
            'status' => 'Enabled',
        ]);
        
        User::factory()->user()->create([
            'name' => 'User',
            'email' => 'user@test.io',
            'status' => 'Enabled',
        ]);

        if (app()->environment(['local'])) {
            $this->call(LocalSeeder::class);
        }
    }
}
