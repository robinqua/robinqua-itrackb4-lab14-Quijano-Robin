<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_displays_the_confirmation_field(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create an account')
            ->assertSee('name="password_confirmation"', false);
    }

    public function test_registration_rejects_mismatched_passwords(): void
    {
        $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Robin Quijano',
                'email' => 'robin@example.com',
                'password' => 'password-one',
                'password_confirmation' => 'password-two',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'robin@example.com']);
    }

    public function test_registration_rejects_an_existing_email(): void
    {
        User::factory()->create(['email' => 'robin@example.com']);

        $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Another Robin',
                'email' => 'robin@example.com',
                'password' => 'correct-horse',
                'password_confirmation' => 'correct-horse',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }

    public function test_registration_creates_a_user_with_a_hashed_password(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Robin Quijano',
            'email' => 'robin@example.com',
            'password' => 'correct-horse',
            'password_confirmation' => 'correct-horse',
        ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('success', 'Welcome, Robin Quijano!');

        $user = User::query()->where('email', 'robin@example.com')->firstOrFail();

        $this->assertSame('Robin Quijano', $user->name);
        $this->assertTrue(password_verify('correct-horse', $user->password));
        $this->assertAuthenticatedAs($user);
    }
}
