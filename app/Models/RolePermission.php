<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    public function sideMenu()
    {
        return $this->belongsTo(sideMenu::class, 'sideMenu_id');
    }
}
