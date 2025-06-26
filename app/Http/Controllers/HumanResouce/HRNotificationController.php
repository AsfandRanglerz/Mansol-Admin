<?php

namespace App\Http\Controllers\HumanResouce;

use App\Http\Controllers\Controller;
use App\Models\NotificationTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRNotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('humanresource')->user();
        if (!$user) {
            abort(401, 'Unauthenticated human resource user');
        }

        $userId = $user->id;

        $notifications = NotificationTarget::where('targetable_type', \App\Models\HumanResource::class)
            ->with('notification')
            ->where('targetable_id', $userId)
            ->latest()
            ->get();

            NotificationTarget::where('targetable_type', \App\Models\HumanResource::class)
            ->where('targetable_id', $userId)
            ->update(['is_read' => true]);

        return view('humanresouce.notification.index', compact('notifications'));
    }
}
