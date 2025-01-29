<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCraft extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function mainCraft()
    {
        return $this->belongsTo(MainCraft::class, 'craft_id');
    }

}
