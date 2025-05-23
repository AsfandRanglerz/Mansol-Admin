<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function rolePermission()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function subAdmin()
    {
        return $this->hasMany(SubAdmin::class,'role_id', 'id');
    }

}
