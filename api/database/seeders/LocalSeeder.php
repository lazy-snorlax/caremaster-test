<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    public function run() {
        $user = User::where('email', 'user@test.io')->first();
        $admin = User::where('email', 'admin@test.io')->first();

        $companies = Company::factory(rand(4, 8))->create();

        foreach ($companies as $company) {
            Employee::factory(rand(3, 8))->create([
                'company_id' => $company->id
            ]);
        }
    }
}