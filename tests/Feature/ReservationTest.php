<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    protected User $customerUser;
    protected User $adminUser;
    protected Studio $studio;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerUser = User::updateOrCreate(
            ['email' => 'customer_res_test@gmail.com'],
            [
                'name' => 'Doni Customer',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'phone' => '081234567891',
            ]
        );

        $this->adminUser = User::updateOrCreate(
            ['email' => 'admin_res_test@studiomusik.com'],
            [
                'name' => 'Admin Studio Res',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '08117524560',
            ]
        );

        $this->studio = Studio::firstOrCreate(
            ['name' => 'Studio A'],
            [
                'capacity' => '4-6 orang',
                'description' => 'Studio lengkap',
                'price_per_hour' => 70000,
                'status' => 'aktif',
            ]
        );
    }

    protected function tearDown(): void
    {
        Reservation::where('user_id', $this->customerUser->id)->delete();
        User::whereIn('email', [
            'customer_res_test@gmail.com',
            'admin_res_test@studiomusik.com',
        ])->delete();

        parent::tearDown();
    }

    /**
     * Pastikan tamu tidak bisa mengakses form reservasi.
     */
    public function test_guest_cannot_access_reservation_create(): void
    {
        $response = $this->get('/reservations/create');
        $response->assertRedirect('/login');
    }

    /**
     * Pastikan admin dialihkan jika membuka halaman reservasi pelanggan.
     */
    public function test_admin_is_redirected_from_reservation_create(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/reservations/create');
        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Pastikan pelanggan dapat melihat halaman form reservasi baru.
     */
    public function test_customer_can_render_reservation_create_page(): void
    {
        $response = $this->actingAs($this->customerUser)->get('/reservations/create');

        $response->assertStatus(200);
        $response->assertSee('Reservasi baru');
        $response->assertSee('Pilih studio & tanggal');
        $response->assertSee('Pilih slot jam');
        $response->assertSee('Ringkasan biaya');
        $response->assertSee('Konfirmasi reservasi');
    }

    /**
     * Pastikan endpoint booked-slots mengembalikan data slot terisi dalam format JSON.
     */
    public function test_booked_slots_endpoint_returns_json(): void
    {
        $date = now()->addDays(2)->toDateString();

        Reservation::create([
            'booking_code' => 'TEST-001',
            'user_id' => $this->customerUser->id,
            'studio_id' => $this->studio->id,
            'reservation_date' => $date,
            'start_time' => '18.00',
            'end_time' => '20.00',
            'duration_hours' => 2,
            'total_price' => 140000,
            'status' => 'menunggu_bayar',
            'payment_status' => 'belum_bayar',
        ]);

        $response = $this->actingAs($this->customerUser)->getJson("/reservations/booked-slots?studio_id={$this->studio->id}&date={$date}");

        $response->assertStatus(200);
        $response->assertJson([
            'studio_id' => (string) $this->studio->id,
            'date' => $date,
        ]);
        $this->assertContains('18.00', $response->json('booked_slots'));
        $this->assertContains('19.00', $response->json('booked_slots'));
    }

    /**
     * Pastikan reservasi baru berhasil disimpan ke database.
     */
    public function test_customer_can_store_reservation(): void
    {
        $date = now()->addDays(3)->toDateString();

        $response = $this->actingAs($this->customerUser)->post('/reservations', [
            'studio_id' => $this->studio->id,
            'reservation_date' => $date,
            'slots' => ['18.00', '19.00'],
            'notes' => 'Latihan band 4 orang',
            'agree_terms' => '1',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reservations', [
            'user_id' => $this->customerUser->id,
            'studio_id' => $this->studio->id,
            'reservation_date' => $date,
            'start_time' => '18.00',
            'end_time' => '20.00',
            'duration_hours' => 2,
            'total_price' => 140000,
            'status' => 'menunggu_bayar',
            'payment_status' => 'belum_bayar',
        ]);
    }
}
