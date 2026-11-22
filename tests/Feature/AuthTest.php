<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan akun pengujian
        User::updateOrCreate(
            ['email' => 'admin_test@studiomusik.com'],
            [
                'name' => 'Admin Pengujian',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '08117524569',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelanggan_test@gmail.com'],
            [
                'name' => 'Pelanggan Pengujian',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'phone' => '081234567890',
            ]
        );
    }

    protected function tearDown(): void
    {
        User::whereIn('email', [
            'admin_test@studiomusik.com',
            'pelanggan_test@gmail.com',
        ])->delete();

        parent::tearDown();
    }

    /**
     * Pastikan halaman login dapat diakses dan menampilkan komponen visual utama.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Studio Musik Positif');
        $response->assertSee('Ruang untuk bermusik.');
        $response->assertSee('Lebih banyak musik.');
        $response->assertSee('Lebih sedikit urusan jadwal.');
        $response->assertSee('Publik / desktop');
        $response->assertSee('Masuk ke akunmu');
        $response->assertSee('Selamat datang kembali di Studio Musik Positif.');
        $response->assertSee('rayhandwijaksono@gmail.com');
        $response->assertSee('Tampilkan');
        $response->assertSee('Ingat saya');
        $response->assertSee('Lupa kata sandi?');
        $response->assertSee('Masuk');
        $response->assertSee('Akun pelanggan dan admin masuk melalui formulir yang sama.');
        $response->assertSee('Daftar sekarang');
        $response->assertSee('Kembali ke beranda');
        $response->assertSee('Kebijakan Privasi');
    }

    /**
     * Pastikan validasi bekerja saat input kosong.
     */
    public function test_login_validation_requires_email_and_password(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    /**
     * Pastikan login gagal dengan password salah.
     */
    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'pelanggan_test@gmail.com',
            'password' => 'passwordsalah',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Pastikan pelanggan berhasil login dan diarahkan ke /dashboard.
     */
    public function test_pelanggan_can_authenticate_and_redirect_to_customer_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'pelanggan_test@gmail.com',
            'password' => 'password123',
            'remember' => '1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');

        $dashboardResponse = $this->get('/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Pelanggan Pengujian');
        $dashboardResponse->assertSee('pelanggan');
    }

    /**
     * Pastikan admin berhasil login dan diarahkan ke /admin/dashboard.
     */
    public function test_admin_can_authenticate_and_redirect_to_admin_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin_test@studiomusik.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/admin/dashboard');

        $adminDashboardResponse = $this->get('/admin/dashboard');
        $adminDashboardResponse->assertStatus(200);
        $adminDashboardResponse->assertSee('Admin Pengujian');
        $adminDashboardResponse->assertSee('admin');
    }

    /**
     * Pastikan logout berhasil menghapus sesi dan kembali ke landing page.
     */
    public function test_users_can_logout(): void
    {
        $user = User::where('email', 'pelanggan_test@gmail.com')->first();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * Pastikan pengguna yang belum login dialihkan saat mengakses dashboard.
     */
    public function test_unauthenticated_users_redirected_to_login_from_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $adminResponse = $this->get('/admin/dashboard');
        $adminResponse->assertRedirect('/login');
    }

    /**
     * Pastikan pengguna yang sudah login dialihkan dari halaman login (guest middleware).
     */
    public function test_authenticated_user_cannot_visit_login_screen(): void
    {
        $user = User::where('email', 'pelanggan_test@gmail.com')->first();

        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect();
    }
}
