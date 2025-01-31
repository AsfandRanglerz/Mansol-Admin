<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nominate extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function humanResource()
    {
        return $this->belongsTo(HumanResource::class, 'human_resource_id');
    }
    public function project()
    {
        return $this->belongsTo(project::class, 'project_id');
    }
    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
    public function craft()
    {
        return $this->belongsTo(MainCraft::class, 'craft_id');
    }
}
