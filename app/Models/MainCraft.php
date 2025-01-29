<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCraft extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function subCrafts()
    {
        return $this->hasMany(SubCraft::class, 'craft_id', 'id');
    }

    public function demands()
    {
        return $this->hasMany(Demand::class);
    }
}
