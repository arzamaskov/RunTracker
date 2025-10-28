<?php

namespace Tests\Feature\Identity;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_a_user_can_register(): void
    {
        // arrange
        $email = 'test@test.com';
        $name = 'Test User';
        $password = 'password';

        // act
        $response = $this->postJson('/register', [
            'email' => $email,
            'name' => $name,
            'password' => $password,
        ]);

        // assert
        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'User registered successfully']);

        self::assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name,
        ]);

        $user = User::query()->whereEmail($email)->first();
        self::assertTrue(Hash::check($password, $user->password));
    }
}
