<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SubAdmin extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $guarded=[];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public static function hasSpecificPermission($subadminId, $sideMenuName, $permissionType)
    {
        $subadmin = self::with('role.rolePermission.sideMenu')->find($subadminId);

        if (!$subadmin || !$subadmin->role) {
            return false;
        }

        foreach ($subadmin->role->rolePermission as $permission) {
            if (
                $permission->sideMenu &&
                strtolower($permission->sideMenu->name) === strtolower($sideMenuName) &&
                strtolower($permission->name) === strtolower($permissionType)
            ) {
                return true;
            }
        }

        return false;
    }



}
