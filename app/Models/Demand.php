<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Define the relationship with the Project model
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Define the relationship with the MainCraft model
    public function craft()
    {
        return $this->belongsTo(MainCraft::class);
    }
}
