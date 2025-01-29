<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['project_start_date', 'project_end_date', 'permission_date'];

    public function demands()
    {
        return $this->hasMany(Demand::class);
    }
}
