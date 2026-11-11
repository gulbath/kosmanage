<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\Occupancy;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_alur_lengkap_pembayaran_transfer_dan_verifikasi_owner(): void
    {
        Storage::fake('local');

        // 1. Buat Data Uji Secara Eksplisit
        $owner = User::create([
            'name' => 'Owner Test',
            'email' => 'owner_test@example.com',
            'password' => 'password123',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $tenant = User::create([
            'name' => 'Tenant Test',
            'email' => 'tenant_test@example.com',
            'password' => 'password123',
            'role' => 'tenant',
            'status' => 'active',
        ]);

        $room = Room::create([
            'room_number' => 'K-101',
            'type' => 'Standard AC',
            'price' => 1000000,
            'status' => 'occupied',
        ]);

        $occupancy = Occupancy::create([
            'room_id' => $room->id,
            'user_id' => $tenant->id,
            'agreed_price' => 1000000,
            'start_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        // 2. Owner Terbitkan Tagihan
        $this->actingAs($owner);
        $responseBill = $this->post(route('owner.bills.store'), [
            'occupancy_id' => $occupancy->id,
            'period_month' => (int) now()->month,
            'period_year' => (int) now()->year,
            'due_date' => now()->addDays(7)->toDateString(),
        ]);
        $responseBill->assertRedirect(route('owner.bills.index'));

        $bill = Bill::first();
        $this->assertNotNull($bill, 'Tagihan gagal dibuat di database.');
        $this->assertEquals('unpaid', $bill->status);

        // 3. Tenant Upload Bukti Bayar (Gunakan create() tanpa memanggil GD extension)
        $this->actingAs($tenant);
        $file = UploadedFile::fake()->create('bukti_tf.jpg', 100, 'image/jpeg');
        
        $responseConfirm = $this->post(route('tenant.bills.confirm', $bill->id), [
            'amount' => 1000000,
            'proof_file' => $file,
        ]);
        $responseConfirm->assertRedirect(route('tenant.bills.show', $bill->id));

        $bill->refresh();
        $this->assertEquals('pending', $bill->status);

        $payment = Payment::first();
        $this->assertNotNull($payment, 'Pembayaran gagal dibuat di database.');
        $this->assertEquals('pending', $payment->status);

        // 4. Owner Menyetujui (Approve) Pembayaran
        $this->actingAs($owner);
        $responseVerify = $this->post(route('owner.payments.verify', $payment->id), [
            'status' => 'approved',
            'remarks' => 'Transfer sesuai',
        ]);
        $responseVerify->assertSessionHasNoErrors();

        $bill->refresh();
        $payment->refresh();

        // 5. Verifikasi Akhir
        $this->assertEquals('approved', $payment->status);
        $this->assertEquals('paid', $bill->status);
        $this->assertDatabaseHas('payment_verifications', [
            'payment_id' => $payment->id,
            'verified_by' => $owner->id,
            'status' => 'approved',
        ]);
    }
}