<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Occupancy;
use App\Models\Bill;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Owner
        $owner = User::create([
            'name' => 'Budi Pemilik',
            'email' => 'owner@kosmanage.com',
            'phone' => '081234567890',
            'role' => 'owner',
            'password' => Hash::make('OwnerSecure123!'),
        ]);

        // 2. Akun Tenant
        $tenant1 = User::create([
            'name' => 'Andi Penyewa',
            'email' => 'tenant@kosmanage.com',
            'phone' => '089876543210',
            'role' => 'tenant',
            'password' => Hash::make('TenantSecure123!'),
        ]);

        $tenant2 = User::create([
            'name' => 'Bambang Penyewa',
            'email' => 'bambang@kosmanage.com',
            'phone' => '089876543211',
            'role' => 'tenant',
            'password' => Hash::make('TenantSecure123!'),
        ]);

        // 3. Kamar Kos
        $room1 = Room::create([
            'room_number' => 'A-01',
            'monthly_price' => 1500000.00,
            'status' => 'occupied',
            'description' => 'Kasur Springbed, AC, Lemari, Kamar Mandi Dalam',
        ]);

        $room2 = Room::create([
            'room_number' => 'A-02',
            'price' => 1200000.00,
            'status' => 'occupied',
            'description' => 'Kasur Springbed, Kipas Angin, Kamar Mandi Luar',
        ]);

        Room::create([
            'room_number' => 'A-03',
            'price' => 1500000.00,
            'status' => 'available',
            'description' => 'Kasur Springbed, AC, Lemari, Kamar Mandi Dalam',
        ]);

        // 4. Penempatan Kamar (Occupancy)
        $occ1 = Occupancy::create([
            'room_id' => $room1->id,
            'tenant_id' => $tenant1->id,
            'start_date' => '2026-10-01',
            'status' => 'active',
        ]);

        $occ2 = Occupancy::create([
            'room_id' => $room2->id,
            'tenant_id' => $tenant2->id,
            'start_date' => '2026-11-01',
            'status' => 'active',
        ]);

        // 5. Tagihan (Bills)
        Bill::create([
            'occupancy_id' => $occ1->id,
            'period' => '2026-11',
            'amount' => 1500000.00,
            'due_date' => '2026-11-10',
            'status' => 'unpaid',
        ]);

        Bill::create([
            'occupancy_id' => $occ2->id,
            'period' => '2026-11',
            'amount' => 1200000.00,
            'due_date' => '2026-11-10',
            'status' => 'unpaid',
        ]);

        // 6. Pengeluaran Operasional
        Expense::create([
            'description' => 'Pembayaran Listrik & Air Area Publik',
            'amount' => 350000.00,
            'expense_date' => '2026-11-02',
            'created_by' => $owner->id,
        ]);
    }
}