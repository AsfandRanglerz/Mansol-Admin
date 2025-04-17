public function edit($id)
{
    $HumanResource = HumanResource::find($id);

    if (!$HumanResource) {
        abort(404, 'Human Resource not found');
    }

    $craft = MainCraft::find($HumanResource->craft_id);
    $nominates = Nominate::where('human_resource_id', $id)->first();
    $subCraft = SubCraft::find($HumanResource->sub_craft_id);
    $companies = Company::latest()->get();
    $crafts = MainCraft::latest()->get();
    $subCrafts = SubCraft::latest()->get();

    $project = null;
    $company = null;
    $demand = null;

    if ($nominates) {
        $project = Project::find($nominates->project_id);
        $company = $project ? Company::find($project->company_id) : null;
        $demand = $nominates->demand_id ? Demand::find($nominates->demand_id) : null;
    }

    $histories = JobHistory::where('human_resource_id', $id)->latest()->get();

    return view('admin.humanresouce.edit', compact(
        'HumanResource',
        'crafts',
        'subCrafts',
        'companies',
        'craft',
        'project',
        'demand',
        'company',
        'subCraft',
        'histories'
    ));
}

public function getAllCrafts()
{
    $crafts = MainCraft::all(); // Fetch all crafts from the database
    return response()->json($crafts);
}
