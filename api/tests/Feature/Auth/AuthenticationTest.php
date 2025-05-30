<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\isNull;
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testCanLoginWithCorrectEmailAndPassword()
    {
        $this->createUser(['email' => 'john@email.com']);
        $response = $this->postJson('api/login', [
            'email' => 'john@email.com', 
            'password' => 'Secret*12345',
        ]);
        $response->assertSuccessful();
    }

    public function testCanGetLoggedInAdminUser() {        
        $response = $this->be($user = $this->createAdmin())->getJson('api/user');
        $response->assertSuccessful();
        
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $user->id)
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->has('abilities')
                )
        ));
    }

    public function testCanGetLoggedInUser() {        
        $response = $this->be($user = $this->createUser())->getJson('api/user');
        $response->assertSuccessful();
        
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $user->id)
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                    ->has('abilities')
                )
        ));
    }

    public function testCannotLoginWithInvalidEmail() {
        $response = $this->postJson('api/login', ['email' => 'john@email.com', 'password' => 'Secret*12345']);
        $response->assertStatus(422);
        $response->assertJsonFragment(['email' => ['These credentials do not match our records.']]);
    }

    public function testCannotLoginWithInvalidPassword()
    {
        $this->createAdmin(['email' => 'john@email.com']);

        $response = $this->postJson('api/login', ['email' => 'john@email.com', 'password' => 'Secret*32145']);
        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'These credentials do not match our records.']);
    }

    public function testLoggedInUserCanLogoutAndHaveSessionDestroyed() {
        $user = $this->createUser();
        $response = $this->be($user)->postJson('api/logout');
        $response->assertSuccessful();
    }
    
    public function testLoggedInUserCanUpdateTheirAccount() {
        $user = $this->createUser();
        $response = $this->be($user)->putJson('api/user', [
            'name' => 'Clark Kent',
            'email' => 'c.kent@dailyplanet.org',
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $user->id)
                ->where('name', 'Clark Kent')
                ->where('email', 'c.kent@dailyplanet.org')
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $user->role->id)
                    ->where('name', $user->role->name)
                    ->where('title', $user->role->title)
                )
        ));
    }
    
    public function testLoggedInAdminCanUpdateTheirAccount() {
        $admin = $this->createAdmin();
        $response = $this->be($admin)->putJson('api/user', [
            'name' => 'Lois Lane',
            'email' => 'l.lane@dailyplanet.org',
        ]);
        $response->assertSuccessful();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has('data', fn (AssertableJson $json) => $json
                ->where('id', $admin->id)
                ->where('name', 'Lois Lane')
                ->where('email', 'l.lane@dailyplanet.org')
                ->has('role', fn (AssertableJson $json) => $json
                    ->where('id', $admin->role->id)
                    ->where('name', $admin->role->name)
                    ->where('title', $admin->role->title)
                )
        ));
    }

    public function testLoggedInUserCanChangeTheirPassword() {
        $user = $this->createUser();
        $response = $this->be($user)->putJson('api/user/password', [
            'current_password' => 'Secret*12345',
            'password' => 'Secret*123',
            'password_confirmation' => 'Secret*123',
        ]);
        $response->assertSuccessful();
    }

    public function testLoggedInUserChangingTheirPasswordWithWrongPassword() {
        $user = $this->createUser();
        $response = $this->be($user)->putJson('api/user/password', [
            'current_password' => 'Secret12345',
            'password' => 'Secret*123',
            'password_confirmation' => 'Secret*123',
        ]);
        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'Current password is incorrect']);
    }
}
