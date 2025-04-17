<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model
{
    use HasFactory;

    Protected $guarded = [];
    public function humanResource()
    {
        return $this->belongsTo(HumanResource::class,'human_resource_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }

    public function demand()
    {
        return $this->belongsTo(Demand::class,'demand_id');
    }

    public function craft()
    {
        return $this->belongsTo(MainCraft::class,'craft_id');
    }

    public function subCraft()
    {
        return $this->belongsTo(SubCraft::class,'sub_craft_id');
    }
}
