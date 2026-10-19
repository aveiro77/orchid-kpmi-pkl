<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get(route('platform.login'));

        $response->assertStatus(200);
    }

    public function test_login_page_displays_custom_branding_and_no_orchid_default_branding(): void
    {
        $response = $this->get(route('platform.login'));

        $response->assertStatus(200);
        $response->assertSee(config('app.name'));

        // Ensure default Orchid footer branding and links are removed
        $response->assertDontSee('Lipetsk');
        $response->assertDontSee('Alexandr Chernyaev');
        $response->assertDontSee('https://orchid.software');
        $response->assertDontSee('Crafted with');
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post(route('platform.login.auth'), [
            'email' => 'nonexistent@example.com',
            'password' => 'invalid-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest('web');
    }

    public function test_login_succeeds_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->post(route('platform.login.auth'), [
            'email' => 'admin@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('platform.main'));
        $this->assertAuthenticatedAs($user, 'web');
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web');

        $response = $this->post(route('platform.logout'));

        $response->assertRedirect('/');
        $this->assertGuest('web');
    }
}
