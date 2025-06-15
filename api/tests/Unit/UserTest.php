<?php

use App\Models\User;
use App\Models\User\Ability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testListUsers()
    {
        $admin = $this->createAdmin();
        $user1 = User::factory()->user()->enabled()->create();
        $user2 = User::factory()->user()->enabled()->create();
        $user3 = User::factory()->user()->enabled()->create();
        User::factory(30)->user()->enabled()->create();

        $response = $this->be($admin)->getJson('api/users');
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', 34)
            ->has('data.1', fn ($json) => $json
                ->where('id', $user1->id)
                ->where('name', $user1->name)
                ->where('email', $user1->email)
                ->where('status', $user1->status)
                ->etc()
            )
            ->where('data.2.id', $user2->id)
            ->where('data.3.id', $user3->id)
            ->etc()
        );
    }

    public function testShowUser()
    {
        $admin = $this->createAdmin();
        $user = User::factory()
            ->user()
            ->enabled()
            ->create()
            ->allow(Ability::READ_USERS);
        $response = $this->be($admin)->getJson("api/users/$user->id");
        $response->assertSuccessful();
        $response->assertJson(['data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->title,
            'status' => $user->status,
        ]]);
    }

    public function testShowSelf()
    {
        $user = $this->createAdmin(["status" => "ENABLED"]);
        $response = $this->be($user)->getJson("api/users/$user->id");
        $response->assertSuccessful();
        $response->assertJson(['data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->title,
            'status' => "ENABLED",
        ]]);
    }

    public function testStoreUser()
    {
        $admin = $this->createAdmin(["status" => "ENABLED"]);
        $response = $this->be($admin)->postJson("api/users/add", [
            'name' => 'John Smith',
            'email' => 'test1@test.io',
            'password' => 'Secret*12345',
        ]);

        $response->assertSuccessful();
        $user = User::where('email', 'test1@test.io')->first();
        $response->assertJson(['data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->title,
            'status' => "PENDING",
        ]]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Smith',
            'email' => 'test1@test.io',
            'status' => 'PENDING',
        ]);
    }

    public function testUpdateUser()
    {
        $admin = $this->createAdmin(["status" => "ENABLED"]);
        $user = User::factory()->user()->enabled()->create(['name' => 'user1']);
        $response = $this->be($admin)->putJson("api/users/$user->id", [
            'email' => 'foo@bar.com',
            'name' => 'John Smith',
            'status' => "DISABLED",
        ]);
        $response->assertSuccessful();
        $response->assertJson(['data' => [
            'id' => $user->id,
            'name' => 'John Smith',
            'email' => 'foo@bar.com',
            'status' => "DISABLED",
        ]]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'John Smith',
            'email' => 'foo@bar.com',
            'status' => 'DISABLED',
        ]);
    }

    // public function testUpdateUserRole()
    // {
    //     $admin = $this->createAdmin(["status" => "ENABLED"]);
    //     $user = User::factory()->user()->enabled()->create(['name' => 'user1']);
    //     $response = $this->be($admin)->putJson("api/users/$user->id", [
    //         'email' => 'foo@bar.com',
    //         'name' => 'John Smith',
    //         'status' => "DISABLED",
    //         'role' => "Admin"
    //     ]);
    //     $response->assertSuccessful();
    //     $response->assertJson(['data' => [
    //         'id' => $user->id,
    //         'name' => 'John Smith',
    //         'email' => 'foo@bar.com',
    //         'status' => "DISABLED",
    //         'role' => "Admin"
    //     ]]);
    //     $this->assertDatabaseHas('users', [
    //         'id' => $user->id,
    //         'name' => 'John Smith',
    //         'email' => 'foo@bar.com',
    //         'status' => 'DISABLED',
    //     ]);
    // }

    public function testDeleteUser()
    {
        $admin = $this->createAdmin(["status" => "ENABLED"]);
        $user = User::factory()->user()->enabled()->create();
        $response = $this->be($admin)->deleteJson("api/users/$user->id");

        $response->assertSuccessful();
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => 'DISABLED',
        ]);

    }
}