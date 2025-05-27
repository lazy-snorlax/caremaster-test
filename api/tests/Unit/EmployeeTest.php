<?php

namespace Tests\Feature\Auth;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\isNull;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanCreateEmployee() {
        $admin = $this->createAdmin();

        $company1 = Company::factory()->create();
        $response = $this->be($admin)->postJson('api/employees/add', [
            "first_name" => "Harry",
            "last_name" => "Potter",
            "email" => "test@test.io",
            "address" => "123 Fake Street",
            "company_id" => $company1->id,
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->has('id')
                ->where('first_name', "Harry")
                ->where('last_name', "Potter")
                ->where('email', "test@test.io")
                ->where('address', "123 Fake Street")
        ));
    }

    public function testAdminCanGetEmployee() {
        $admin = $this->createAdmin();

        $company1 = Company::factory()->create();
        $employee = Employee::factory()->create([ 'company_id' => $company1->id ]);

        $response = $this->be($admin)->getJson('api/employees/'.$employee->id);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $employee->id)
                ->where('first_name', $employee->first_name)
                ->where('last_name', $employee->last_name)
                ->where('email', $employee->email)
                ->where('address', $employee->address)
        ));
    }
    
    public function testAdminCanUpdateEmployee() {
        $admin = $this->createAdmin();

        $company1 = Company::factory()->create();
        $employee = Employee::factory()->create([ 'company_id' => $company1->id ]);

        $response = $this->be($admin)->putJson('api/employees/'.$employee->id, [
            "first_name" => "Harry",
            "last_name" => "Potter",
            "email" => $employee->email,
            "address" => $employee->address,
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json)  => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $employee->id)
                ->where('first_name', "Harry")
                ->where('last_name', "Potter")
                ->where('email', $employee->email)
                ->where('address', $employee->address)
        ));
    }
    
    public function testAdminCanDeleteEmployee() {
        $admin = $this->createAdmin();

        $company1 = Company::factory()->create();
        $employee = Employee::factory()->create([ 'company_id' => $company1->id ]);

        $response = $this->be($admin)->deleteJson('api/employees/'.$employee->id);
        $response->assertSuccessful();
    }
}