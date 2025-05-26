<?php

namespace Tests\Feature\Auth;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\isNull;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanGetCompanyList() {
        $admin = $this->createAdmin();

        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();

        $response = $this->be($admin)->getJson('api/companies');
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', 2, fn (AssertableJson $json) => $json
                ->where('id', $company1->id)
                ->where('name', $company1->name)
                ->where('email', $company1->email)
                ->where('abn', $company1->abn)
                ->where('address', $company1->address)
                ->has('employees')
        ));
    }

    public function testAdminCanGetCompany() {
        $admin = $this->createAdmin();
        $company = Company::factory()->create();
        $response = $this->be($admin)->getJson('api/companies/'.$company->id);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $company->id)
                ->where('name', $company->name)
                ->where('email', $company->email)
                ->where('abn', $company->abn)
                ->where('address', $company->address)
                ->has('employees')
        ));
    }

    public function testAdminCanUpdateCompany() {
        $admin = $this->createAdmin();
        $company = Company::factory()->create();
        $response = $this->be($admin)->putJson('api/companies/'.$company->id, [
            'name' => 'Testing Company',
            'address' => 'Mars Space Base',
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $company->id)
                ->where('name', 'Testing Company')
                ->where('email', $company->email)
                ->where('abn', $company->abn)
                ->where('address', 'Mars Space Base')
                ->has('employees')
        ));
    }

    public function testAdminCanCreateACompany() {
        $admin = $this->createAdmin();
        $response = $this->be($admin)->postJson('api/companies/add', [
            'name' => 'Testing Company',
            'email' => 'testing@test.io',
            'abn' => 12345678901,
            'address' => 'Mars Space Base',
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('name', 'Testing Company')
                ->where('email', 'testing@test.io')
                ->where('abn', 12345678901)
                ->where('address', 'Mars Space Base')
                ->has('employees')
        ));
    }
    
    public function testUserCannotGetCompanyList() {
        $user = $this->createUser();
        
        $response = $this->be($user)->getJson('api/companies');
        $response->assertStatus(400);
        $response->assertJsonFragment(['message' => 'Admin role not assigned.']);
    }
}