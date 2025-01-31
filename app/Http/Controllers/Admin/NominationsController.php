<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;
use App\Models\Nominate;

class NominationsController extends Controller
{
    public function index()
    {
        // $HumanResources = HumanResource::where('status', 3)->latest('updated_at')->get();
        $nominates = Nominate::with(['humanResource', 'demand', 'project', 'craft'])->get();
        // dd($nominates);
        return view('admin.nominations.index', compact('nominates'));
    }

    public function destroy($id)
    {
        // return $id;
        HumanResource::destroy($id);
        return redirect()->route('nominations.index')->with(['message' => 'Nomination Deleted Successfully']);
    }
}
