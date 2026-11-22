<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    protected User $adminUser;
    protected User $pelangganUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::updateOrCreate(
            ['email' => 'admin_test_msg@studiomusik.com'],
            [
                'name' => 'Admin Pengujian Pesan',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '08117524569',
            ]
        );

        $this->pelangganUser = User::updateOrCreate(
            ['email' => 'pelanggan_test_msg@gmail.com'],
            [
                'name' => 'Pelanggan Pengujian Pesan',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'phone' => '081234567890',
            ]
        );
    }

    protected function tearDown(): void
    {
        ContactMessage::where('email', 'test_pengirim@example.com')->delete();
        User::whereIn('email', [
            'admin_test_msg@studiomusik.com',
            'pelanggan_test_msg@gmail.com',
        ])->delete();

        parent::tearDown();
    }

    /**
     * Pastikan formulir kontak dapat menyimpan pesan ke database contact_messages.
     */
    public function test_contact_form_saves_message_to_database(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Budi Gitaris',
            'email' => 'test_pengirim@example.com',
            'message' => 'Halo, apakah studio A tersedia untuk hari Sabtu malam?',
        ]);

        $response->assertSessionHas('contact_success', 'Pesan Anda berhasil dikirim ke Studio Musik Positif.');
        $response->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Gitaris',
            'email' => 'test_pengirim@example.com',
            'message' => 'Halo, apakah studio A tersedia untuk hari Sabtu malam?',
            'is_read' => false,
        ]);
    }

    /**
     * Pastikan validasi form kontak menolak input kosong.
     */
    public function test_contact_form_validation_rejects_empty_fields(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'bukan-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    /**
     * Pastikan tamu (guest) yang belum login tidak bisa mengakses /admin/dashboard.
     */
    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Pastikan pengguna dengan peran pelanggan tidak bisa mengakses dashboard admin (403 Forbidden).
     */
    public function test_customer_role_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->pelangganUser)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Pastikan admin dapat melihat daftar pesan masuk di /admin/dashboard.
     */
    public function test_admin_can_view_contact_messages(): void
    {
        $message = ContactMessage::create([
            'name' => 'Doni Drummer',
            'email' => 'test_pengirim@example.com',
            'message' => 'Berapa biaya sewa double pedal?',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Doni Drummer');
        $response->assertSee('test_pengirim@example.com');
        $response->assertSee('Berapa biaya sewa double pedal?');
        $response->assertSee('Belum dibaca');
        $response->assertSee('Tandai Sudah Dibaca');
        $response->assertSee('Hapus');

        $message->delete();
    }

    /**
     * Pastikan admin dapat menandai pesan sebagai sudah dibaca (PATCH).
     */
    public function test_admin_can_mark_message_as_read(): void
    {
        $message = ContactMessage::create([
            'name' => 'Rian Bassist',
            'email' => 'test_pengirim@example.com',
            'message' => 'Apakah ada ampli bass Ampeg?',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->adminUser)->patch("/admin/messages/{$message->id}/read");

        $response->assertRedirect();
        $response->assertSessionHas('admin_success');

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'is_read' => true,
        ]);

        $message->delete();
    }

    /**
     * Pastikan admin dapat menghapus pesan (DELETE).
     */
    public function test_admin_can_delete_message(): void
    {
        $message = ContactMessage::create([
            'name' => 'Pesan Sampah',
            'email' => 'test_pengirim@example.com',
            'message' => 'Tawaran promosi tidak relevan.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->adminUser)->delete("/admin/messages/{$message->id}");

        $response->assertRedirect();
        $response->assertSessionHas('admin_success');

        $this->assertDatabaseMissing('contact_messages', [
            'id' => $message->id,
        ]);
    }

    /**
     * Pastikan pelanggan biasa tidak dapat menandai pesan atau menghapus pesan.
     */
    public function test_customer_cannot_mark_or_delete_messages(): void
    {
        $message = ContactMessage::create([
            'name' => 'Tes Keamanan',
            'email' => 'test_pengirim@example.com',
            'message' => 'Uji otorisasi pesan.',
            'is_read' => false,
        ]);

        $patchResponse = $this->actingAs($this->pelangganUser)->patch("/admin/messages/{$message->id}/read");
        $patchResponse->assertStatus(403);

        $deleteResponse = $this->actingAs($this->pelangganUser)->delete("/admin/messages/{$message->id}");
        $deleteResponse->assertStatus(403);

        $message->delete();
    }
}
