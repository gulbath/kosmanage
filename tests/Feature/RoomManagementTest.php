<?php

namespace Tests\Feature;

use App\Models\Occupancy;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Room Test',
            'email' => 'owner_room@example.com',
            'password' => 'password123',
            'role' => 'owner',
            'status' => 'active',
        ]);
    }

    public function test_owner_dapat_menambah_kamar_baru(): void
    {
        $this->actingAs($this->owner);

        $response = $this->post(route('owner.rooms.store'), [
            'room_number' => 'K-101',
            'type' => 'Deluxe AC',
            'price' => 1500000,
            'status' => 'available',
        ]);

        $response->assertRedirect(route('owner.rooms.index'));
        $this->assertDatabaseHas('rooms', [
            'room_number' => 'K-101',
            'price' => 1500000,
        ]);
    }

    public function test_kamar_terisi_tidak_dapat_dihapus(): void
    {
        $tenant = User::create([
            'name' => 'Tenant Room Test',
            'email' => 'tenant_room@example.com',
            'password' => 'password123',
            'role' => 'tenant',
            'status' => 'active',
        ]);

        $room = Room::create([
            'room_number' => 'K-102',
            'type' => 'Standard',
            'price' => 1000000,
            'status' => 'occupied',
        ]);

        Occupancy::create([
            'room_id' => $room->id,
            'user_id' => $tenant->id,
            'agreed_price' => 1000000,
            'start_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        $this->actingAs($this->owner);

        // Menggunakan from() agar pengalihan back() dikenali oleh test runner
        $response = $this->from(route('owner.rooms.index'))
            ->delete(route('owner.rooms.destroy', $room->id));

        $response->assertRedirect(route('owner.rooms.index'));
        $response->assertSessionHasErrors('error');

        // Memastikan kamar tidak terhapus (deleted_at tetap NULL)
        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'deleted_at' => null,
        ]);
    }
}