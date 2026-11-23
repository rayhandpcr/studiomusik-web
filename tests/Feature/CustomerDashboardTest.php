<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerDashboardTest extends TestCase
{
    protected User $customerUser;
    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerUser = User::updateOrCreate(
            ['email' => 'customer_dash_test@gmail.com'],
            [
                'name' => 'Budi Pelanggan',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'phone' => '081234567890',
            ]
        );

        $this->adminUser = User::updateOrCreate(
            ['email' => 'admin_dash_test@studiomusik.com'],
            [
                'name' => 'Admin Studio',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '08117524569',
            ]
        );
    }

    protected function tearDown(): void
    {
        User::whereIn('email', [
            'customer_dash_test@gmail.com',
            'admin_dash_test@studiomusik.com',
        ])->delete();

        parent::tearDown();
    }

    /**
     * Pastikan tamu (guest) yang belum login tidak bisa mengakses /dashboard.
     */
    public function test_unauthenticated_user_cannot_access_customer_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Pastikan admin yang mengakses /dashboard dialihkan otomatis ke /admin/dashboard.
     */
    public function test_admin_accessing_customer_dashboard_redirects_to_admin_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertRedirect('/admin/dashboard');
    }

    /**
     * Pastikan pelanggan dapat mengakses /dashboard dan melihat seluruh elemen visual.
     */
    public function test_customer_can_render_dashboard_with_all_components(): void
    {
        $response = $this->actingAs($this->customerUser)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Studio Musik');
        $response->assertSee('Positif');
        $response->assertSee('Pelanggan / desktop');
        $response->assertSee('Dashboard pelanggan');
        $response->assertSee('Budi');
        $response->assertSee('Reservasi aktif');
        $response->assertSee('Jadwal bulan ini');
        $response->assertSee('Belum dibayar');
        $response->assertSee('Jadwal terdekat');
        $response->assertSee('Notifikasi terbaru');
        $response->assertSee('Reservasi terbaru');
        $response->assertSee('Keluar');
    }
}
