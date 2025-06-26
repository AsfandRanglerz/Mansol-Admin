<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCraft;
use App\Models\MainCraft;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class SubCraftController extends Controller
{
    public function index($id)
    {
        $mainCraft = MainCraft::find($id);

        $subCrafts = SubCraft::where('craft_id', $id)->orderBy('status', 'desc')->get();
        // return $subCraft;
        return view('admin.subcraft.index', compact('mainCraft', 'subCrafts'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // Validate the incoming request data
        $request->validate([
            'craft_id' => 'required|exists:main_crafts,id', // Ensure craft_id corresponds to an existing MainCraft
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        // Create a new SubCraft record
        SubCraft::create([
            'craft_id' => $request->craft_id,
            'name' => $request->name,
            'status' => $request->status,
        ]);

        // Redirect to the subcraft index page with a success message
        return redirect()->route('subcraft.index', ['id' => $request->craft_id])->with(['message' => 'Sub-Craft Created Successfully']);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);


        $subCraft = SubCraft::findOrFail($id);

        // Update the record
        $subCraft->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('subcraft.index', ['id' => $request->craft_id])->with('message', 'Sub-Craft Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        // return $id;
        try{
            SubCraft::destroy($id);
            return redirect()->route('subcraft.index', ['id' => $request->craft_id])->with(['message' => 'Sub-Craft Deleted Successfully']);
        } catch (QueryException $e){
            return redirect()->route('subcraft.index', ['id' => $request->craft_id])->with(['error' => 'This Sub-Craft cannot be deleted as it is linked to Human Resources or Company Demands.']);
        }
    }
}
