<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display the notification list page.
     */
    public function index(Request $request): View|RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Buat pengingat jadwal otomatis jika ada jadwal terkonfirmasi hari ini / besok
        CustomerNotification::checkAndCreateScheduleReminders($user);

        $filter = $request->query('filter');

        $allCount = CustomerNotification::where('user_id', $user->id)->count();
        $unreadCount = CustomerNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        $query = CustomerNotification::with(['reservation.studio'])
            ->where('user_id', $user->id);

        if ($filter === 'unread') {
            $query->where('is_read', false);
        }

        $notifications = $query->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', [
            'user' => $user,
            'notifications' => $notifications,
            'allCount' => $allCount,
            'unreadCount' => $unreadCount,
            'filter' => $filter,
        ]);
    }

    /**
     * Mark a single notification as read and redirect to target.
     */
    public function markAsRead(CustomerNotification $notification): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_if($notification->user_id !== $user->id, 403);

        $notification->update(['is_read' => true]);

        // Redirect kontekstual sesuai tipe notifikasi
        if ($notification->type === 'payment_reminder' && $notification->reservation_id) {
            return redirect()->route('reservations.payment', $notification->reservation_id);
        }

        if ($notification->type === 'cost_split_incomplete' && $notification->reservation_id) {
            return redirect()->route('cost-splits.index', ['reservation_id' => $notification->reservation_id]);
        }

        if ($notification->reservation_id) {
            return redirect()->route('reservations.show', $notification->reservation_id);
        }

        return redirect()->route('reservations.index');
    }

    /**
     * Mark all user notifications as read.
     */
    public function markAllRead(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        CustomerNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->route('notifications.index')
            ->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
        }
}
