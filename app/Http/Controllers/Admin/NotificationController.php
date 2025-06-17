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
            'user_type' => 'required|in:company,human_resource',
            'target_ids_by_type' => 'required|string',
            'message' => 'required|string',
        ]);

        $type = $request->user_type;

        $notification = Notification::create([
            'type' => $type,
            'message' => $request->message,
        ]);

        $targetsByType = json_decode($request->target_ids_by_type, true);

        foreach ($targetsByType[$type] ?? [] as $id) {
            $modelClass = $type === 'company' ? \App\Models\Company::class : \App\Models\HumanResource::class;

            NotificationTarget::create([
                'notification_id' => $notification->id,
                'targetable_id' => $id,
                'targetable_type' => $modelClass,
            ]);
        }

        return response()->json(['message' => 'Notification created successfully']);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'user_type' => 'required|in:company,human_resource',
        'target_ids' => 'required|array',
        'message' => 'required|string',
    ]);

    $notification = Notification::findOrFail($id);
    $notification->message = $request->message;
    $notification->type = $request->user_type;
    $notification->save();

    // Sync recipients
    $notification->targets()->delete();

    $modelClass = $request->user_type === 'company'
        ? \App\Models\Company::class
        : \App\Models\HumanResource::class;

    foreach ($request->target_ids as $target_id) {
        $notification->targets()->create([
            'targetable_id' => $target_id,
            'targetable_type' => $modelClass,
        ]);
    }

    return response()->json(['message' => 'Notification updated successfully.']);
}



    // fetch hrs and companies
    public function fetchRecipients(Request $request)
    {
        $type = $request->type;

        $results = [];

        if ($type === 'company') {
            $companies = Company::select('id', 'name')->get();
            foreach ($companies as $company) {
                $results[] = [
                    'id' => $company->id,
                    'name' => $company->name,
                    'type' => 'company',
                ];
            }
        }

        if ($type === 'human_resource') {
            $hrs = HumanResource::select('id', 'name')->get();
            foreach ($hrs as $hr) {
                $results[] = [
                    'id' => $hr->id,
                    'name' => $hr->name,
                    'type' => 'human_resource',
                ];
            }
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
