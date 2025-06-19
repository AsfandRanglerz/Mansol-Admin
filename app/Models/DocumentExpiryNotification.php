<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentExpiryNotification extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function targets()
    {
        return $this->morphMany(NotificationTarget::class, 'notificationable');
    }
}
