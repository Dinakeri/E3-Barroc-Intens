<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return view('notifications.admin.notifications', compact('user'));
        } elseif ($user->role === 'finance') {
            return view('notifications.admin.notifications', compact('user'));
        } elseif ($user->role === 'maintenance') {
            return view('notifications.maintenance.notifications', compact('user'));
        } elseif ($user->role === 'sales') {
            return view('notifications.sales.notifications', compact('user'));
        } elseif ($user->role === 'purchasing') {
            return view('notifications.purchasing.notifications', compact('user'));
        }
        // return view('notifications.index', compact('user'));
    }

    public function markAllRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
        return redirect()->route('notifications.index')->with('success', 'Alle notificaties gemarkeerd als gelezen.');
    }

    public function markRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return redirect()->route('notifications.index')->with('success', 'Notificatie gemarkeerd als gelezen.');
    }

    public function markUnread($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsUnread();
        return redirect()->route('notifications.index')->with('success', 'Notificatie gemarkeerd als ongelezen.');
    }

    public function markAllUnread()
    {
        $user = auth()->user();
        $user->notifications->markAsUnread();
        return redirect()->route('notifications.index')->with('success', 'Alle notificaties gemarkeerd als ongelezen.');
    }

    public function destroy($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->delete();
        return redirect()->route('notifications.index')->with('success', 'Notificatie verwijderd.');
    }
}
