<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrStep extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function humanResource()
    {
        return $this->belongsTo(HumanResource::class);
    }
}
