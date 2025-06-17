<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\NotificationTarget;
use Illuminate\Http\Request;

class CompanyNotificationController extends Controller
{
    public function index()
    {
         $user = auth('company')->user();
        if (!$user) {
            abort(401, 'Unauthenticated company');
        }

        $userId = $user->id;

        $notifications = NotificationTarget::where('targetable_type', \App\Models\Company::class)
            ->with('notification')
            ->latest()
            ->get();

            NotificationTarget::where('targetable_type', \App\Models\Company::class)
            ->where('targetable_id', $userId)
            ->update(['is_read' => true]);

        return view('companypanel.notification.index', compact('notifications'));
    }
}
