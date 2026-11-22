<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Studio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $studios = collect();

        if (Schema::hasTable('studios')) {
            $studios = Studio::where('status', 'aktif')->get();
        }

        // Data default agar halaman langsung tampil sesuai desain meskipun database belum diisi
        if ($studios->isEmpty()) {
            $studios = collect([
                (object) [
                    'id' => 1,
                    'name' => 'Studio A',
                    'capacity' => '4-6 orang',
                    'description' => 'AC, 2 mic, 3 speaker, 1 gitar listrik, 1 gitar bass, 1 keyboard, 1 drum',
                    'price_per_hour' => 70000,
                    'image' => 'images/studio-a.jpg',
                ],
                (object) [
                    'id' => 2,
                    'name' => 'Studio B',
                    'capacity' => '8-10 orang',
                    'description' => 'AC, 2 mic, 3 speaker, 1 gitar listrik, 1 gitar bass, 1 keyboard, 1 drum',
                    'price_per_hour' => 70000,
                    'image' => 'images/studio-b.jpg',
                ],
                (object) [
                    'id' => 3,
                    'name' => 'Studio C',
                    'capacity' => '4-6 orang',
                    'description' => 'AC, 2 mic, 3 speaker, 1 gitar listrik, 1 gitar bass, 1 keyboard, 1 drum',
                    'price_per_hour' => 70000,
                    'image' => 'images/studio-c.jpg',
                ],
            ]);
        }

        $facilities = [
            'Ruang ber-AC',
            'Peredam suara',
            'Drum set lengkap',
            'Gitar listrik',
            'Gitar bass',
            'Mikrofon vokal dan speaker',
            'Wi-Fi gratis',
            'Keyboard',
        ];

        return view('landing', compact('studios', 'facilities'));
    }

    public function sendContact(Request $request): RedirectResponse
    {
        if (! $request->has('name') && $request->has('nama')) {
            $request->merge(['name' => $request->input('nama')]);
        }
        if (! $request->has('message') && $request->has('pesan')) {
            $request->merge(['message' => $request->input('pesan')]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 150 karakter.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return back()
            ->with('contact_success', 'Pesan Anda berhasil dikirim ke Studio Musik Positif.')
            ->withFragment('kontak');
    }
}
