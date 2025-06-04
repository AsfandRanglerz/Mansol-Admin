<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notification.index');
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'user_type' => 'required|in:all,farmers,authorized_dealers',
            'message' => 'required|string|max:1000',
        ]);

        // dd($request);
        $user_type = $validated['user_type'];
        $message = $validated['message'];

        // Notification::create([
        //     'user_type' => $user_type,
        //     'message' => $message,
        // ]);

        return redirect()->route('notification.index')->with(['message'  =>  'Notification saved successfully! It will be sent later.']);

    }
}
