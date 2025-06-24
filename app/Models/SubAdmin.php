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

}
