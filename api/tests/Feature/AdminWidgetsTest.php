<?php

namespace Tests\Feature\Auth;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\isNull;

class AdminWidgetsTest extends TestCase 
{
    use RefreshDatabase;

    public function testAdminCanGetWidgets() {
        $admin = $this->createAdmin();

        Company::factory(5)->create();
        User::factory(3)->create();
        Employee::factory(10)->create([
            'company_id' => Company::first()->id
        ]);

        $response = $this->be($admin)->getJson('api/dashboard');
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->where('total_companies', 5)
            ->where('total_employees', 10)
            ->where('total_users', 4)
        );
    }

    public function testUserCannotGetWidgets() {
        $user1 = $this->createUser();
        
        Company::factory(5)->create();
        $admin = $this->createAdmin();
        $user2 = $this->createUser();
        $user3 = $this->createUser();

        $response = $this->be($user1)->getJson('api/dashboard');
        $response->assertStatus(400);
        $response->assertJsonFragment(["message" => "Admin role not assigned."]);
    }
}