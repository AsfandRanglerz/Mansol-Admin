<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sideMenu extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'sideMenu_id');
    }

}
