<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HumanResource extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    // public function Crafts()
    // {
    //     return $this->hasMany(MainCraft::class, 'craft_id', 'id');
    // }

    public function Crafts()
    {
        return $this->belongsTo(MainCraft::class, 'craft_id', 'id');
    }

    public function SubCrafts()
    {
        return $this->belongsTo(SubCraft::class, 'sub_craft_id', 'id');
    }

    public function hrSteps(){
        return $this->hasMany(HrStep::class,'human_resource_id');
    }
}
