<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\HumanResource;
use App\Models\Notification;
use App\Models\NotificationTarget;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
{
    $notifications = Notification::with('targets.targetable')->latest()->get();

    $companies = Company::select('id', 'name')->get();
    $humanResources = HumanResource::select('id', 'name')->get();

    return view('admin.notification.index', compact('notifications', 'companies', 'humanResources'));
}



    public function store(Request $request)
    {
        $request->validate([
            'user_type' => 'required|array',
            'user_type.*' => 'in:company,human_resource',
            'target_ids' => 'required|array',
            'message' => 'required|string',
        ]);

        // If both company and HR are selected, store as 'both'
        $type = count($request->user_type) === 2 ? 'both' : $request->user_type[0];

        // Create the notification
        $notification = Notification::create([
            'type' => $type,
            'message' => $request->message,
        ]);

        // Assign recipients polymorphically
        foreach ($request->user_type as $type) {
            $modelClass = $type === 'company' ? \App\Models\Company::class : \App\Models\HumanResource::class;

            foreach ($request->target_ids as $id) {
                NotificationTarget::create([
                    'notification_id' => $notification->id,
                    'targetable_id' => $id,
                    'targetable_type' => $modelClass,
                ]);
            }
        }

        return response()->json(['message' => 'Notification created successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_type' => 'required|array',
            'target_ids' => 'required|array',
            'message' => 'required|string'
        ]);

        $notification = Notification::findOrFail($id);
        $notification->message = $request->message;
        $notification->type = count($request->user_type) > 1 ? 'both' : $request->user_type[0];
        $notification->save();

        // Sync recipients
        $notification->targets()->delete(); // Or use detach for many-to-many
        foreach ($request->user_type as $type) {
            foreach ($request->target_ids as $target_id) {
                $notification->targets()->create([
                    'targetable_id' => $target_id,
                    'targetable_type' => $type === 'company' ? \App\Models\Company::class : \App\Models\HumanResource::class,
                ]);
            }
        }

        return response()->json(['message' => 'Notification updated successfully.']);
    }


    // fetch hrs and companies
    public function fetchRecipients(Request $request)
    {
        $types = $request->input('types');

        $results = collect();

        if (in_array('company', $types)) {
            $companies = Company::select('id', 'name')->get();
            $results = $results->merge($companies);
        }

        if (in_array('human_resource', $types)) {
            $hr = HumanResource::select('id', 'name')->get();
            $results = $results->merge($hr);
        }

        return response()->json($results);
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->targets()->delete();
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully');
    }
}
