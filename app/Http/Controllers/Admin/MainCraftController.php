<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCraft;
use App\Models\MainCraft;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class MainCraftController extends Controller
{
    public function index()
    {
        $mainCrafts = MainCraft::orderBy('status', 'desc')->latest()->get();
        return view('admin.maincraft.index', compact('mainCrafts'));
    }

    public function create()
    {
        return view('admin.maincraft.create');
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        // Create a new subadmin record
        MainCraft::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        // Return success message
        return redirect()->route('maincraft.index')->with(['message' => 'MainCraft Created Successfully']);
    }


    public function edit($id)
    {

        $mainCraft = MainCraft::find($id);
        // return $subAdmin;

        return view('admin.maincraft.edit', compact('mainCraft'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $mainCraft = MainCraft::findOrFail($id);

        $mainCraft->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('maincraft.index')->with('message', 'MainCraft Updated Successfully');
    }

    public function destroy($id)
    {
        // return $id;
        try{
            MainCraft::destroy($id);
            return redirect()->route('maincraft.index')->with(['message' => 'MainCraft Deleted Successfully']);
        } catch (QueryException $e) {
            return redirect()->route('maincraft.index')->with(['error' => 'This MainCraft cannot be deleted as it is linked to Human Resources or Company Demands.']);
        }
    }

    public function getSubCrafts(Request $request)
    {
        $craftId = $request->input('craft_id');

        $subCrafts = SubCraft::where('craft_id', $craftId)->where('status', 1)->get();

        return response()->json($subCrafts);
    }
}
