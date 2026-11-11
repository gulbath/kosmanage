<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_login_dapat_diakses(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_owner_dapat_login_dan_diarahkan_ke_dashboard_owner(): void
    {
        $owner = User::create([
            'name' => 'Pemilik Kos',
            'email' => 'owner_login@example.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'status' => 'active',
        ]);

        $response = $this->post('/login', [
            'email' => 'owner_login@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($owner);
        $response->assertRedirect(route('owner.dashboard'));
    }

    public function test_registrasi_publik_selalu_menghasilkan_role_tenant(): void
    {
        $response = $this->post('/register', [
            'name' => 'Calon Penyewa',
            'email' => 'calon@tenant.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '081234567890',
            'role' => 'owner',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'calon@tenant.com',
            'role' => 'tenant',
        ]);

        $response->assertRedirect(route('tenant.dashboard'));
    }
}