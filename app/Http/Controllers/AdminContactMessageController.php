<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminContactMessageController extends Controller
{
    /**
     * Display the admin dashboard with incoming contact messages.
     */
    public function index(): View
    {
        $messages = ContactMessage::latest()->get();

        return view('dashboard.admin', [
            'user' => Auth::user(),
            'messages' => $messages,
            'totalMessages' => $messages->count(),
            'unreadCount' => $messages->where('is_read', false)->count(),
            'readCount' => $messages->where('is_read', true)->count(),
        ]);
    }

    /**
     * Mark the specified contact message as read.
     */
    public function markAsRead(ContactMessage $message): RedirectResponse
    {
        $message->update(['is_read' => true]);

        return back()->with('admin_success', "Pesan dari \"{$message->name}\" berhasil ditandai sudah dibaca.");
    }

    /**
     * Remove the specified contact message from storage.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $name = $message->name;
        $message->delete();

        return back()->with('admin_success', "Pesan dari \"{$name}\" berhasil dihapus.");
    }
}
