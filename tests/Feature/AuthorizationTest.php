<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\Occupancy;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_tidak_dapat_mengakses_dashboard_owner(): void
    {
        $tenant = User::create([
            'name' => 'Tenant Test',
            'email' => 'tenant_auth@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
            'status' => 'active',
        ]);

        $this->actingAs($tenant);
        $response = $this->get(route('owner.dashboard'));

        $response->assertStatus(403);
    }

    public function test_tenant_tidak_dapat_melihat_tagihan_milik_tenant_lain_idor_prevention(): void
    {
        $tenantA = User::create([
            'name' => 'Tenant A',
            'email' => 'tenant_a@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
            'status' => 'active',
        ]);

        $tenantB = User::create([
            'name' => 'Tenant B',
            'email' => 'tenant_b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
            'status' => 'active',
        ]);

        $room = Room::create([
            'room_number' => 'K-102',
            'type' => 'Standard',
            'price' => 1000000,
            'status' => 'occupied',
        ]);

        $occupancyB = Occupancy::create([
            'room_id' => $room->id,
            'user_id' => $tenantB->id,
            'agreed_price' => 1000000,
            'start_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        $billTenantB = Bill::create([
            'bill_number' => 'INV-202611-999',
            'occupancy_id' => $occupancyB->id,
            'user_id' => $tenantB->id,
            'period_month' => (int) now()->month,
            'period_year' => (int) now()->year,
            'amount' => 1000000,
            'due_date' => now()->addDays(7)->toDateString(),
            'status' => 'unpaid',
        ]);

        // Tenant A mencoba membuka halaman detail tagihan milik Tenant B
        $this->actingAs($tenantA);
        $response = $this->get(route('tenant.bills.show', $billTenantB->id));

        $response->assertStatus(403);
    }
}