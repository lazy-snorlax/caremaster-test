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

    public function testCanGetLoggedInUser() {        
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
}
