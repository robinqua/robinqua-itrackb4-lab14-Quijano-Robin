<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_has_a_csrf_protected_post_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Log in')
            ->assertSee('action="'.route('login.store').'"', false)
            ->assertSee('name="_token"', false);
    }

    public function test_invalid_credentials_return_one_generic_error_without_old_password(): void
    {
        User::factory()->create([
            'email' => 'known@example.com',
            'password' => 'correct-password',
        ]);

        $response = $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'known@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->assertSessionHas('_old_input.email', 'known@example.com')
            ->assertSessionMissing('_old_input.password');

        $this->assertGuest();

        $missingEmailResponse = $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'unknown@example.com',
                'password' => 'wrong-password',
            ]);

        $missingEmailResponse->assertSessionHasErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function test_valid_credentials_authenticate_and_redirect_to_the_books_index(): void
    {
        $user = User::factory()->create([
            'email' => 'known@example.com',
            'password' => 'correct-password',
        ]);

        $this->post(route('login.store'), [
            'email' => 'known@example.com',
            'password' => 'correct-password',
        ])
            ->assertRedirect(route('books.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_must_be_post_and_ends_the_authenticated_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('logout'))
            ->assertMethodNotAllowed();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('success', 'You have been logged out.');

        $this->assertGuest();
    }

    public function test_navigation_uses_a_post_form_for_logout_when_authenticated(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertOk()
            ->assertSee('method="POST"', false)
            ->assertSee('action="'.route('logout').'"', false)
            ->assertSee('name="_token"', false);
    }
}
